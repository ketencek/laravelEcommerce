<?php

namespace App\Models;

use App\Traits\Model;
use App\Traits\Translatable;

class OrderStatus extends Model
{
    use Translatable;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];
    protected $guarded = ['id'];

     /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
    ];

     /**
     * The attributes that are translatable.
     *
     * @var array
     */
    protected $translatedAttributes = ['name', 'subject'];
    
    protected static function booted()
    {
        static::addActiveGlobalScope();
    }


}
