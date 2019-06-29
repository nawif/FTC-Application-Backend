<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->mediumText('whatsapp_link')->nullable();

                $table->bigInteger('leader_id')->unsigned();
                $table->foreign('leader_id')->references('id')->on('users');

                $table->mediumText('description');
                $table->integer('user_limit');
                $table->date('date')->default(now());
                $table->string('status')->default('READY'); //READY= IN PORGRESS , DONE=FINISHED, FULL = users in event  == limit
                $table->string('type');	// ORGANIZE OR ATTEND
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
        Schema::dropIfExists('events');
    }
}
