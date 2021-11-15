<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonElementTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_element_types', function (Blueprint $table) {
            $table->id();

            $table->string('slug');

            $table->timestamps();
        });

        Schema::create('lesson_element_type_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lesson_element_type_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->string('description');
            $table->unique(['lesson_element_type_id','locale'], 'lesson_element_type_id_locale_unique');
            $table->foreign('lesson_element_type_id')->references('id')->on('lesson_element_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lesson_element_type_translations');
        Schema::dropIfExists('lesson_element_types');
    }
}
