<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_elements', function (Blueprint $table) {
            $table->id();

            $table->string('icon')->nullable();

            $table->unsignedBigInteger('element_type_id');
            $table->foreign('element_type_id')->references('id')->on('lesson_element_types')->onDelete('cascade');

            $table->json('data')->nullable();

            $table->timestamps();
        });

        Schema::create('lesson_element_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lesson_element_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unique(['lesson_element_id','locale'], 'lesson_element_type_id_locale_unique');
            $table->foreign('lesson_element_id')->references('id')->on('lesson_elements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lesson_element_translations');
        Schema::dropIfExists('lesson_elements');
    }
}
