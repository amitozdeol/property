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
    protected $table = 'property_unit';
}
