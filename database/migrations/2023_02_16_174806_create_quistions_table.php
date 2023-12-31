<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuistionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quistions', function (Blueprint $table) {
            $table->id();
            $table->string('quistion');
            $table->string('answer');
            $table->string('option1');
            $table->string('option2');
            $table->string('option3');
            $table->string('option4');
            $table->string('option5');
            $table->unsignedBigInteger('quiz_id');
            $table->foreign('quiz_id')->references('id')->on('quizzes')->cascadeOnDelete();
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
        Schema::dropIfExists('quistions');
    }
}
