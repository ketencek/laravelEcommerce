<?php

namespace App\Models;

use App\Traits\Model;
use App\Scopes\OrderScope;

class Banner extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    
    protected static function booted()
    {
        static::addGlobalScope(new OrderScope);
        static::addActiveGlobalScope();
    }
}
