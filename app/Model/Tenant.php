<?php

namespace App\Model;

use App\Model\Property;
use App\Model\PropertyUnit;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tenant';

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('lease_end', function (Builder $builder) {
            $builder->whereDate('tenant.lease_end', '>=', Carbon::now());
        });
    }

    /**
     * Scope a query to only include tenants for current logged in user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMyTenant($query)
    {
        return $query->join('property_unit', 'tenant.property_unit_id', '=', 'property_unit.id')
                    ->join('property', 'property.id', '=', 'property_unit.property_id')
                    ->where('property.user_id', Auth::guard('api')->id());
    }
}
