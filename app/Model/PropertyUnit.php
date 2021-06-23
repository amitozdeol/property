<?php

namespace App\Model;

use App\Model\Tenant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PropertyUnit extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'property_unit';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['unit', 'rent', 'size', 'address'];

    /**
     * Get the tenant for the unit
     */
    public function tenants()
    {
        return $this->hasMany(Tenant::class, 'property_unit_id', 'id');
    }

}
