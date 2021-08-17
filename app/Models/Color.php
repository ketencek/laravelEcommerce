<?php 

namespace App\Models;

// use Modules\Admin\Ui\AdminTable;
use App\Traits\Model;
use App\Traits\Translatable;
use App\Scopes\OrderScope;
// use App\Scopes\ActiveScope;

class Color extends Model
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
    // protected $fillable = ['slug', 'is_active'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    protected $translatedAttributes = ['name'];

    protected static function booted()
    {
        static::addGlobalScope(new OrderScope);
        static::addActiveGlobalScope();
    }
}