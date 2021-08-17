<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('text')->nullable();
            $table->longText('link')->nullable();
            $table->longText('video_link')->nullable();
            $table->string('image')->nullable();
            $table->string('image_alt')->nullable();
            $table->enum('lang', ['tr', 'en']);
            $table->string('type')->nullable();
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('banners');
    }
}
