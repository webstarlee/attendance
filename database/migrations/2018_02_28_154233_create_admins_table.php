<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username');
            $table->string('unique_id')->unique();
            $table->string('name_title')->nullable();
            $table->string('avatar')->default('default.jpg');
            $table->string('cover')->default('default.jpg');
            $table->string('birth')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('role');
            $table->integer('nation')->nullable();
            $table->string('state')->nullable();
            $table->string('department')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->integer('social_number')->nullable();
            $table->string('personal_number')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('admins');
    }
}
