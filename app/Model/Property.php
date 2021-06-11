<?php

namespace App\Model;

use App\Model\Tenant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Property extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'property';

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('users', function (Builder $builder) {
            $builder->where('user_id', Auth::guard('api')->id());
        });
    }

    /**
     * Get the tenant for the property
     */
    public function tenants()
    {
        return $this->hasMany(Tenant::class, 'property_id', 'id');
    }
}
