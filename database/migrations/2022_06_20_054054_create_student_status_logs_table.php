<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentStatusLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_status_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('course_id');
            $table->foreignId('old_teacher_id')->nullable();
            $table->foreignId('new_teacher_id')->nullable();
            // $table->foreignId('old_course_id');
            // $table->foreignId('new_course_id');
            // $table->integer('year');
            // $table->integer('month');
            $table->integer('return_day')->nullable();
            $table->enum('status',['new','move_normal','move_issue','hold','out','return']);
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
        Schema::dropIfExists('student_status_logs');
    }
}
