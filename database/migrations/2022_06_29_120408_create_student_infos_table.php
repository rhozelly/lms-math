<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id");
            $table->foreignId('grade_id')->nullable();
            $table->string("school_name")->nullable();
            $table->string("parent_name")->nullable();
            $table->string("parent_phone")->nullable();
            $table->string("address")->nullable();
            $table->integer("first_day")->nullable();
            $table->integer("payment_day")->nullable();
            $table->string("inflow_path")->nullable();
            $table->string("etc")->nullable();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_infos');
    }
}
