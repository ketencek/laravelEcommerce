<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderStatusTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_status_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_status_id');
            $table->string('locale');
            $table->string('name');
            $table->string('subject');

            $table->unique(['order_status_id', 'locale']);
            $table->foreign('order_status_id')->references('id')->on('order_statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_status_translations');
    }
}
