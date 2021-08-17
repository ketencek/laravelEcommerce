<?php 

namespace App\Models;

// use App\Traits\Model;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    
    // protected static function booted()
    // {
    //     static::addActiveGlobalScope();
    // }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities()
    {
        return $this->hasMany('App\Models\City');
    }

    public function allCountry()
    {
        return $this->belongsTo(Country::class,'country_id','id')->withoutGlobalScopes();
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    
    // public function countries()
    // {
    //     return $this->hasOne('App\Models\Country', 'id','country_id');
    // }
    // public function getCountryNameAttribute(){

    //     dd('ads');
    //     return $this->countries->name;

    // }
}