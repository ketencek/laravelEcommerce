<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;


class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('status')->default(1)->comment('active = 1');
            $table->string('name')->nullable();
            $table->string('company')->nullable();
            $table->string('vat_no')->nullable();
            $table->string('vat_daire')->nullable();
            $table->string('tc_kimlik_no')->nullable();
            $table->longText('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('postal_code')->nullable();
            $table->boolean('is_company')->default(0);  
            $table->boolean('is_superadmin')->default(0);     
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(
            array(
                'first_name' => 'ketencek',
                'last_name' => 'ketencek',
                'username' => 'ketencek',
                'password' => Hash::make("123456"),
                'email' => 'ketencek@gmail.com',
                'is_superadmin' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
