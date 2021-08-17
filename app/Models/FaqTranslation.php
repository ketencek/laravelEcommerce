<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use App\Traits\TranslationModel;

class FaqTranslation extends TranslationModel
{
    use Sluggable;

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
