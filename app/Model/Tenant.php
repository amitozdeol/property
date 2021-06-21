<?php

namespace App\Model;

use App\Model\Property;
use App\Model\PropertyUnit;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tenant';
}
