<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pro_name');
            $table->string('pro_unid');
            $table->date('pro_start_date');
            $table->date('pro_end_date');
            $table->integer('pro_rate')->nullable();
            $table->integer('pro_rate_type')->nullable();
            $table->integer('pro_priority');
            $table->integer('pro_status');
            $table->binary('pro_leader');
            $table->binary('pro_member');
            $table->text('pro_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
