<?php

namespace App\Http\Controllers;

use App\Model\Tenant;
use App\Model\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_field   = $request->query('sort') == 'null' ? 'tenant.updated_at' : $request->query('sort');
        $order       = $request->query('order') == 'null' ? 'desc' : $request->query('order');
        $search_text = $request->query('search_text') == 'null' ? null : $request->query('search_text');

        $tenants = Tenant::select('tenant.*', 'property_unit.unit', 'property.name as property_name')
                        ->join('property_unit', 'tenant.property_unit_id', '=', 'property_unit.id')
                        ->join('property', 'property.id', '=', 'property_unit.property_id')
                        ->where('property.user_id', Auth::guard('api')->id())
                        ->when($search_text, function($q) use($search_text){
                            return $q->where(function($q1) use($search_text){
                                        $q1->where('tenant.name', 'ilike', '%'.$search_text.'%')
                                        ->orWhere('tenant.email', 'ilike', '%'.$search_text.'%');
                                    });
                        })
                        ->orderBy($sort_field, $order)
                        ->paginate(5);
        return $tenants;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vd = $request->validate([
            'unit_id' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'rent_due' => 'required|integer|between:1,31',
            'lease_start' => 'required|date',
            'lease_end' => 'required|date|after:lease_start',
        ]);

        $tenant = new Tenant();
        $tenant->property_unit_id = $vd['unit_id'];
        $tenant->name = $vd['name'];
        $tenant->email = $vd['email'];
        $tenant->phone = $vd['phone'];
        $tenant->rent_due = $vd['rent_due'];
        $tenant->lease_start = $vd['lease_start'];
        $tenant->lease_end = $vd['lease_end'];
        $tenant->save();

        return response()->json($tenant, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
