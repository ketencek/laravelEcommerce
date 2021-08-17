<?php

namespace App\Models;

// use Modules\Admin\Ui\AdminTable;
use App\Traits\Model;
use App\Traits\Translatable;
use App\Scopes\OrderScope;

class Page extends Model
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
        'on_home' => 'boolean',
    ];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    protected $translatedAttributes = ['title', 'sub_title','short_description', 'description','image_alt', 'meta_title', 'meta_keyword', 'meta_description'];

    /**
     * The attribute that will be slugged.
     *
     * @var string
     */
    // protected $slugAttribute = 'title';

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addActiveGlobalScope();
        static::addGlobalScope(new OrderScope);
    }

    // public static function urlForPage($id)
    // {
    //     return static::select('slug')->firstOrNew(['id' => $id])->url();
    // }

    // public function url()
    // {
    //     if (is_null($this->slug)) {
    //         return '#';
    //     }

    //     return localized_url(locale(), $this->slug);
    // }

    /**
     * Get table data for the resource
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // public function table()
    // {
    //     return new AdminTable($this->newQuery()->withoutGlobalScope('active'));
    // }
}
