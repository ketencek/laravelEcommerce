<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->enum('product_type', ['ColorBase', 'SizeBase', 'BOTH', 'NoColorSize']);
            $table->string('product_code');
            $table->string('banner_image')->nullable();
            $table->boolean('status')->default(0);
            $table->boolean('is_new')->default(0);
            $table->boolean('is_home')->default(0);
            $table->integer('ord')->default(0);
            $table->integer('is_visible_price')->default(0);
            $table->integer('free_shipping')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
