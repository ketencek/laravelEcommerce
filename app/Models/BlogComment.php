<?php

namespace App\Models;

use App\Traits\Model;

class BlogComment extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::addActiveGlobalScope();
    }
}
