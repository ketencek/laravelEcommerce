<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactFormDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_form_details', function (Blueprint $table) {
            $table->id();
            $table->string('mail_type')->nullable();
            $table->string('full_name');
            $table->string('subject');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->longText('message');
            $table->string('image')->nullable();
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
        Schema::dropIfExists('contact_form_details');
    }
}
