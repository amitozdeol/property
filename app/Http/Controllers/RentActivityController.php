<?php

namespace App\Http\Controllers;

use App\Model\Tenant;
use App\Model\Property;
use App\Model\RentActivity;
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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tenant $tenant)
    {
        $vd = $request->validate([
            'rent_month' => 'required|date', //should be a format of yyyy/mm/dd
            'value' => 'required|numeric|between:1,99999.99',
            'remaining' => 'sometimes|numeric|between:1,99999.99',
        ]);

        $rent = new RentActivity();
        $rent->tenant_id = $tenant->id;
        $rent->rent_month = $vd['rent_month'];
        $rent->fully_paid = !isset($vd['remaining']);
        $rent->value = $vd['value'];
        $rent->remaining = $vd['remaining'] ?? 0;
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
