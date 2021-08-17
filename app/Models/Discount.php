<?php

namespace App\Models;

use App\Traits\Model;
use App\Scopes\OrderScope;
use Carbon\Carbon;

class Discount extends Model
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
        'ord' => 'boolean',
        'is_user_id'=>'boolean',
    ];

    protected $appends = ['formated_discount_start_date', 'formated_discount_end_date'];

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

    public function discount_products()
    {
        return $this->hasMany('App\Models\DiscountProduct');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'discount_users')
        ->withTimestamps();
        // return $this->hasMany('App\Models\ProductSize');
    }

    public function products()
    {
        return $this->belongsToMany(User::class, 'discount_users')
        ->withTimestamps();
    }

    public function getFormatedDiscountStartDateAttribute()
    {
        $data = Carbon::parse($this->discount_start_date)->format('d-m-Y H:i');
        return $data;
    }

    public function getFormatedDiscountEndDateAttribute()
    {
        $data = Carbon::parse($this->discount_end_date)->format('d-m-Y H:i');
        return $data;
    }

    public function setDiscountEndDateAttribute($value)
    {
       $this->attributes['discount_end_date'] = Carbon::createFromFormat('d-m-Y H:i', $value)->format('Y-m-d H:i:s');
    }

    public function setDiscountStartDateAttribute($value)
    {
        $this->attributes['discount_start_date'] = Carbon::createFromFormat('d-m-Y H:i', $value)->format('Y-m-d H:i:s');
    }
}