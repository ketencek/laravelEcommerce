<?php

namespace App\Models;

// use Modules\Admin\Ui\AdminTable;
use App\Traits\Model;
use App\Traits\Translatable;
use TypiCMS\NestableTrait;

class Category extends Model
{
    use NestableTrait, Translatable;

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
        'on_home' => 'boolean',
    ];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    protected $translatedAttributes = ['name', 'description'];

    public function isRoot()
    {
        return $this->exists && is_null($this->parent_id);
    }
    
    // protected static function booted()
    // {
    //     static::addActiveGlobalScope();
    // }
    
    public static function tree()
    {
                return static::orderByRaw('-position DESC')
                    ->where('status',1)
                    ->get()
                    ->nest();
    }

    public static function treeList()
    {
            return static::orderByRaw('-position DESC')
                ->get()
                ->nest()
                ->setIndent('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ')
                ->listsFlattened('name');
    }
}
