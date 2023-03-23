<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuantitativeEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quantitative_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id');
            $table->integer('salary');
            $table->text('course_ids');
            $table->text('attendance_ids');
            $table->text('student_status_log_ids');
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
        Schema::dropIfExists('quantitative_evaluations');
    }
}
