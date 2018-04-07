<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->integer('attend_type')->default(1);//default 1 (work) , 0(absence), 2(business trip), 3(vacation), 4(shortvacation), 5(doctor), 6(paragraph), 7(parental leave)
            $table->date('attend_date_from');
            $table->date('attend_date_to');
            $table->time('start_time');
            $table->time('end_time');
            $table->binary('breaks')->nullable();
            $table->binary('smokes')->nullable();
            $table->integer('attend_work_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_requests');
    }
}
