<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Model;
use App\Scopes\OrderScope;

class Option extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function optionvalues()
    {
        return $this->hasMany('App\Models\OptionValue');
    }

    protected static function booted()
    {
        static::addActiveGlobalScope();
        static::addGlobalScope(new OrderScope);
    }
}
