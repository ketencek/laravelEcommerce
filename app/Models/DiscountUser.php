<?php

namespace App\Models;

use App\Traits\Model;
use App\Scopes\OrderScope;

class DiscountUser extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

}
