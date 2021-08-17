<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientLogosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_logos', function (Blueprint $table) {
            $table->id();
            $table->string('link')->nullable();
            $table->string('image')->nullable();
            $table->boolean('on_home')->default(0)->comment('active = 1');
            $table->boolean('status')->default(0)->comment('active = 1');
            $table->integer('ord')->default(0);
            $table->string('cat_type');
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
        Schema::dropIfExists('client_logos');
    }
}
