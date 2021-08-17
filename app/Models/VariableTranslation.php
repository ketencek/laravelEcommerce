<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\TranslationModel;

class VariableTranslation extends TranslationModel
{
    protected $guarded = ['id'];
}
