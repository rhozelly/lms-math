<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseDaysTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_days_times', function (Blueprint $table) {
            $table->id();
            $table->integer('course_id');
            $table->boolean('day1')->nullable();
            $table->boolean('day2')->nullable();
            $table->boolean('day3')->nullable();
            $table->boolean('day4')->nullable();
            $table->boolean('day5')->nullable();
            $table->boolean('day6')->nullable();
            $table->boolean('day7')->nullable();
            $table->time('start_time1')->nullable();
            $table->time('end_time1')->nullable();
            $table->time('start_time2')->nullable();
            $table->time('end_time2')->nullable();
            $table->time('start_time3')->nullable();
            $table->time('end_time3')->nullable();
            $table->time('start_time4')->nullable();
            $table->time('end_time4')->nullable();
            $table->time('start_time5')->nullable();
            $table->time('end_time5')->nullable();
            $table->time('start_time6')->nullable();
            $table->time('end_time6')->nullable();
            $table->time('start_time7')->nullable();
            $table->time('end_time7')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_days_times');
    }
}
