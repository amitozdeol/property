<?php

namespace App\Http\Controllers;

use App\Model\Tenant;
use App\Model\Property;
use App\Model\RentActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

        $tenants = Tenant::myTenant()
                        ->withoutGlobalScope('lease_end')
                        ->select('tenant.*', 'property_unit.unit', 'property.name as property_name')
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
     * Return a list of tenant that has upcoming rent or pending rent
     *
     * @return \Illuminate\Http\Response
     */
    public function rentPending()
    {
        //Find tenants that already paid the rent
        $tenantPaid = RentActivity::select('tenant_id')
                            ->where('rent_month', Carbon::now()->startOfMonth())
                            ->where('fully_paid', true)
                            ->get()
                            ->pluck('tenant_id');

        //Find tenants that's pending
        $tenants = Tenant::myTenant()
                        ->whereNotIn('tenant.id', $tenantPaid)
                        ->where('rent_due', '<=', Carbon::now()->addDays(10)->day) //upcoming rent in next 10 days
                        ->select('tenant.*')
                        ->orderBy('rent_due')
                        ->get();
        return $tenants;

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
