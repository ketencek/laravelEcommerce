<?php

namespace App\Models;

use App\Traits\Model;
use App\Traits\Translatable;
use App\Scopes\OrderScope;

class FaqCategory extends Model
{
    use Translatable;
     /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];

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

     /**
     * The attributes that are translatable.
     *
     * @var array
     */
    protected $translatedAttributes = ['name','short_description', 'meta_title', 'meta_keyword', 'meta_description'];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addActiveGlobalScope();
        static::addGlobalScope(new OrderScope);
    }
}
