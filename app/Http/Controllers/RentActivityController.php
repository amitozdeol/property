<?php

namespace App\Http\Controllers;

use App\Model\Tenant;
use App\Model\Property;
use Carbon\CarbonPeriod;
use App\Model\RentActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RentActivityController extends Controller
{
    /**
     * Display latest income
     *
     * @return \Illuminate\Http\Response
     */
    public function latest()
    {
        $last3month = CarbonPeriod::create(Carbon::now()->subMonth(2), '1 month', 'now');
        $incomes = RentActivity::select('rent_month', DB::raw('sum("value")'))
                            ->where('rent_month', '>=', Carbon::now()->startOfMonth()->subMonths(3))
                            ->groupBy('rent_month')
                            ->get();

        //Add default values when it doesn't exist
        foreach ($last3month as $value) {
            $d = $value->format('Y-m-01 00:00:00');
            $has_date = $incomes->contains(function ($value, $key) use($d){
                            return isset($value->rent_month) && $value->rent_month == $d;
                        });
            if(!$has_date){
                $incomes->push(['rent_month' => $d, 'sum' => 0]);
            }
        }

        return $incomes->sortByDesc('rent_month')->values();
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
            '*' => 'required|array',
            '*.id' => 'sometimes|integer', //rent activity id exist if updating old activity
            '*.rent_month' => 'required|date', //Should be a format of yyyy/mm/dd
            '*.rent_paid' => 'sometimes|numeric|between:1,99999.99'
        ]);
        $actual_rent = $tenant->unit->rent;
        $updates = [];

        foreach ($vd as $activity) {
            //if user provided new rent value
            if(isset($activity['rent_paid'])){

                if(isset($activity['id'])){
                    $old_activity = RentActivity::find($activity['id']);
                }

                //actual rent remaining is the remaining rent
                if(isset($old_activity)){
                    $actual_rent = $old_activity->remaining;
                }

                $fully_paid = $actual_rent == $activity['rent_paid'];

                $rent = new RentActivity();
                $rent->tenant_id = $tenant->id;
                $rent->rent_month = Carbon::create($activity['rent_month'])->startOfMonth();
                $rent->fully_paid = $fully_paid;
                $rent->value = $activity['rent_paid'];
                $rent->remaining = $actual_rent - $activity['rent_paid'];
                $rent->user_id = Auth::guard('api')->id();
                $rent->active = !$fully_paid;
                $rent->save();

                $updates[] = $rent;

                // Inactivate the old activity
                if(isset($old_activity)){
                    $old_activity->active = false;
                    $old_activity->save();
                }
            }
        }
        return response()->json($updates, 201);
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
