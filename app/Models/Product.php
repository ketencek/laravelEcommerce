<?php

namespace App\Models;

// use Modules\Admin\Ui\AdminTable;
use App\Traits\Model;
use App\Traits\Translatable;
use App\Scopes\OrderScope;

class Product extends Model
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
        'is_new'=>'boolean',
        'is_visible_price' =>'boolean',
        'free_shipping' => 'boolean',
    ];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    protected $translatedAttributes = ['name','short_description', 'description', 'meta_title', 'meta_keyword', 'meta_description'];

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

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories')->withTimestamps();
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_colors')
        ->withTimestamps()
        ->withPivot('ord')->orderBy('product_colors.ord');
        // return $this->hasMany('App\Models\ProductSize');
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_sizes')
        ->withTimestamps()
        ->withPivot('ord')->orderBy('product_sizes.ord');
        // return $this->hasMany('App\Models\ProductSize');
    }
    public function product_images()
    {
        return $this->hasMany('App\Models\ProductImage');
    }
 
    public function product_quantities()
    {
        return $this->hasMany('App\Models\ProductQuantity');
    }

    public function product_prices()
    {
        return $this->hasMany('App\Models\ProductPrice');
    }

    public function optionvalues()
    {
        return $this->hasMany('App\Models\ProductOption');
        // return $this->belongsToMany(OptionValue::class, 'product_option_values');
    }

}
