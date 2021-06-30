<?php

namespace App\Model;

use App\Model\Tenant;
use App\Model\PropertyUnit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class RentActivity extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rent_activity';

    protected $casts = [
        'fully_paid' => 'boolean',
    ];

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
     * Get the tenant
     */
    public function tenant()
    {
        return $this->hasOne(Tenant::class, 'id', 'tenant_id');
    }
}
