<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use App\Traits\TranslationModel;

class CategoryTranslation extends TranslationModel
{
    use Sluggable;
    // use HasFactory;
    // protected $slugAttribute = 'title';
    protected $guarded = ['id'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
