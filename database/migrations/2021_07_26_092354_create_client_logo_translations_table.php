<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientLogoTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_logo_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_logo_id');
            $table->string('locale');
            $table->string('name');

            $table->unique(['client_logo_id', 'locale']);
            $table->foreign('client_logo_id')->references('id')->on('client_logos')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_logo_translations');
    }
}
