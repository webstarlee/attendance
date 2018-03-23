<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->integer('contract_id');
            $table->date('attendance_date');
            $table->integer('stauts')->default(1);//default 1 (attendance) , 0(absence), 2(business trip), 3(vacation), 4(sickness)
            $table->time('arrival_time')->nullable();
            $table->time('departur_time')->nullable();
            $table->time('break_start')->nullable();
            $table->time('break_end')->nullable();
            $table->binary('smoking')->nullable();
            $table->integer('total_min')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
