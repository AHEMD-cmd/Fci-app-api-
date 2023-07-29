<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLectureAssignmentAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecture_assignment_answers', function (Blueprint $table) {
            $table->id();
            $table->string('file');

            $table->unsignedBigInteger('lecture_assignment_id');
            $table->foreign('lecture_assignment_id')->references('id')->on('lecture_assignments')->cascadeOnDelete();


            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

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
        Schema::dropIfExists('lecture_assignment_answers');
    }
}
