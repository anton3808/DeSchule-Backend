<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('words', function (Blueprint $table) {
            $table->id();

            $table->string('image')->nullable();

            $table->string('word');
            $table->text('description');

            $table->timestamps();
        });

        Schema::create('word_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('word_id');
            $table->string('locale')->index();
            $table->string('word_translation');
            $table->string('word_description_translation');
            $table->unique(['word_id','locale']);
            $table->foreign('word_id')->references('id')->on('words')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('word_translations');
        Schema::dropIfExists('words');
    }
}
