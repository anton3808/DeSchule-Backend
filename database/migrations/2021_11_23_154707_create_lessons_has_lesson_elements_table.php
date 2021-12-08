<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsHasLessonElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons_has_lesson_elements', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('lesson_id');
            $table->unsignedBigInteger('lesson_element_id');

            $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('cascade');
            $table->foreign('lesson_element_id')->references('id')->on('lesson_elements')->onDelete('cascade');

            $table->unique(['lesson_id','lesson_element_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons_has_lesson_elements');
    }
}
