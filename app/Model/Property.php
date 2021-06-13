<?php

namespace App\Model;

use App\Model\Tenant;
use App\Model\PropertyUnit;
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
     * Get the units for the property
     */
    public function units()
    {
        return $this->hasMany(PropertyUnit::class, 'property_id', 'id');
    }
}
