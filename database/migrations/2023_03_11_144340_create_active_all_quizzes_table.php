<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActiveAllQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active_all_quizzes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('all_quiz_id');
            $table->foreign('all_quiz_id')->references('id')->on('all_quizzes')->cascadeOnDelete();


            $table->timestamp('start_date');

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
        Schema::dropIfExists('active_all_quizzes');
    }
}
