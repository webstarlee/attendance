<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('app_name')->default('HR');
            $table->string('logo_img')->default('default.jpg');
            $table->string('logo_fav')->default('default.jpg');
            $table->time('break1_start')->default('11:30');
            $table->time('break1_end')->default('12:00');
            $table->time('break2_start')->default('14:30');
            $table->time('break2_end')->default('15:00');
            $table->boolean('custom_breaktime')->default(0);
            $table->integer('vacation_week')->default(4);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
