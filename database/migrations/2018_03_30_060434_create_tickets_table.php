<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ticket_unique_id')->nullable();
            $table->string('ticket_subject');
            $table->string('ticket_client');
            $table->string('ticket_staff');
            $table->string('ticket_priority');
            $table->binary('ticket_follower');
            $table->text('ticket_note')->nullable();
            $table->integer('ticket_status');
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
        Schema::dropIfExists('tickets');
    }
}
