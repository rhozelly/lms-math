<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursePresetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_presets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('curriculum_id');
            $table->boolean('day1')->nullable();
            $table->boolean('day2')->nullable();
            $table->boolean('day3')->nullable();
            $table->boolean('day4')->nullable();
            $table->boolean('day5')->nullable();
            $table->boolean('day6')->nullable();
            $table->boolean('day7')->nullable();
            $table->string('type');
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
        Schema::dropIfExists('course_presets');
    }
}
