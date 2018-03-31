<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendPresentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attend_presents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attend_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->time('arrival_time');
            $table->time('departure_time');
            $table->binary('breaks')->nullable();
            $table->binary('smokes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attend_presents');
    }
}
