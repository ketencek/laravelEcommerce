<?php

namespace App\Models;

use App\Traits\Model;
use App\Scopes\OrderScope;

class NewsletterImage extends Model
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
    ];

    public static function booted() {
        static::created(function ($model) {
            $model->ord = $model->id; 
            $model->save();
        });
        static::addActiveGlobalScope();
        static::addGlobalScope(new OrderScope);
    }
}
