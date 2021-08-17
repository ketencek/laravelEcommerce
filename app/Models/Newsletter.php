<?php

namespace App\Models;

use App\Traits\Model;

class Newsletter extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
        'is_subscribed' =>'boolean',
    ];

    protected static function booted()
    {
        static::addActiveGlobalScope();
    }

}
