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
            $table->integer('req_employee_id');
            $table->date('req_attendance_date_from');
            $table->date('req_attendance_date_to');
            $table->integer('req_status')->default(1);//default 1 (attendance) , 0(absence), 2(business trip), 3(vacation), 4(sickness)
            $table->time('req_arrival_time')->nullable();
            $table->time('req_departure_time')->nullable();
            $table->time('req_break1_start')->nullable();
            $table->time('req_break1_end')->nullable();
            $table->time('req_break2_start')->nullable();
            $table->time('req_break2_end')->nullable();
            $table->binary('req_smoking')->nullable();
            $table->integer('req_total_min')->nullable();
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
        Schema::dropIfExists('attendance_requests');
    }
}
