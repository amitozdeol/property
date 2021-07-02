<?php

namespace App\Model;

use App\Model\PropertyUnit;
use App\Model\RentActivity;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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

    /**
     * Get the unit for the tenant
     */
    public function unit()
    {
        return $this->belongsTo(PropertyUnit::class, 'property_unit_id', 'id');
    }

    /**
     * Get the rent activity for the tenant. Show any pending rent or upcoming rent
     */
    public function rent_activity()
    {
        return $this->hasMany(RentActivity::class, 'tenant_id', 'id')
                    ->where('fully_paid', false)
                    ->where('active', true);
    }
}
