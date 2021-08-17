<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public static function booted() {
        static::created(function (ProductSize $model) {
            $model->ord = $model->id; 
            $model->save();
        });

    }
}
