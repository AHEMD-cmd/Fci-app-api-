<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionAssignmentAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section_assignment_answers', function (Blueprint $table) {
            $table->id();

            $table->string('file');


            $table->unsignedBigInteger('section_assignment_id');
            $table->foreign('section_assignment_id')->references('id')->on('section_assignments')->cascadeOnDelete();


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
        Schema::dropIfExists('section_assignment_answers');
    }
}
