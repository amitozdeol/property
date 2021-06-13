<?php

namespace App\Http\Controllers;

use App\Model\Property;
use App\Model\PropertyUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Property::get();
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
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required|max:999999|integer',
            'units' => 'required|array',
            'units.*.unit' => 'required|string',
            'units.*.size' => 'nullable|integer',
            'units.*.address' => 'required|string'
        ]);

        $property = new Property();
        $property->name = $vd['name'];
        $property->address = $vd['address'];
        $property->city = $vd['city'];
        $property->state = $vd['state'];
        $property->zip = $vd['zip'];
        $property->user_id = Auth::guard('api')->id();
        $property->save();

        $units = [];
        foreach ($vd['units'] as $key => $value) {
            $value = (array) $value;
            $value['property_id'] = $property->id;
            $units[] = new PropertyUnit((array)$value);
        }

        $property->units()->saveMany($units);
        return response()->json($property, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Property::with(['units.tenants'])->find($id);
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
