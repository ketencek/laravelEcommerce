<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function booted() {
        static::created(function ($model) {
            $model->ord = $model->id; 
            $model->save();
        });

    }
}
