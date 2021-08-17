<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsletterImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletter_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('newsletter_message_id');
            $table->string('image');
            $table->string('link')->nullable();
            $table->enum('image_type', ['image', 'attachment']);
            $table->boolean('status')->default(1); 
            $table->integer('ord')->default(0);
            $table->timestamps();
            $table->foreign('newsletter_message_id')->references('id')->on('newsletter_messages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('newsletter_images');
    }
}
