<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimingSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timing_sheets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pro_id');
            $table->string('employee_id');
            $table->date('sheet_date');
            $table->integer('work_time');
            $table->text('sheet_note')->nullable();
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
        Schema::dropIfExists('timing_sheets');
    }
}
