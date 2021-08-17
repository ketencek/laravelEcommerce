<?php

namespace App\Models;

use App\Traits\Model;

class Language extends Model
{
    protected $guarded = ['id'];

     /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
        'is_front' => 'boolean',
    ];

}
