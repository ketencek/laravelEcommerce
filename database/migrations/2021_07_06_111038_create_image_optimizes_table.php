<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageOptimizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_optimizes', function (Blueprint $table) {
            $table->id();
            $table->string('module_name');
            $table->string('thumb_folder');
            $table->boolean('is_optimise')->default(1);
            $table->string('width');
            $table->string('height');
            $table->string('crop_ratio')->nullable();
            $table->integer('ord')->default(0);
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
        Schema::dropIfExists('image_optimizes');
    }
}
