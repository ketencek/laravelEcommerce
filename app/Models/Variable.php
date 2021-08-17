<?php

namespace App\Models;

use App\Traits\Model;
use App\Traits\Translatable;

class Variable extends Model
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

    protected $translatedAttributes = ['value'];

    protected static function booted()
    {
        static::addActiveGlobalScope();
    }

    public static function saveInTranslationFile(){
        
        $variable = self::where('status', 1)->get();
        $variable_array= [];
        foreach($variable as $v ) {
            foreach($v['translations'] as $k=>$v1) {
                $variable_array[$v1['locale']][$v['name']] = $v1['value'];
            }
        }

        foreach($variable_array as $lang => $v_array) {
            file_put_contents(base_path() .'/resources/lang/'.$lang.'.json',  json_encode($v_array));
        }
    }
}
