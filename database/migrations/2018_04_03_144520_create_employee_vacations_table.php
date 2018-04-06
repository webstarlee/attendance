<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeVacationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_vacations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('employee_id');
            $table->integer('vac_year');
            $table->integer('vac_total_min');
            $table->integer('vac_extra_min');
            $table->integer('vac_spend_min');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_vacations');
    }
}
