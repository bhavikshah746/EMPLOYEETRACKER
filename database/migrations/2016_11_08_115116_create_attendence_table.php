<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendence', function (Blueprint $table) {
            $table->increments('id');
            $table->date('day');
            $table->time('start_time');
            $table->string('start_ip',255);
            $table->time('end_time');
            $table->string('end_ip',255);
            $table->text('note');
            $table->tinyInteger('draft');
            $table->dateTime('edit');
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('attendence');
    }
}
