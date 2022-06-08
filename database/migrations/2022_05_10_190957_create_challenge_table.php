<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallengeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('character', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->timestamps();
        });

        Schema::create('challenge', function (Blueprint $table) {
            $table->id();

            $table->integer('order');

            $table->unsignedBigInteger('level_id');
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');

            $table->integer('dt');
            $table->string('status')->default('active')->comment('active/passed');

            $table->timestamps();
        });

        Schema::create('challenge_translation', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('challenge_id');
            $table->foreign('challenge_id')->references('id')->on('challenge')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('title');
        });

         Schema::create('challenge_exercise', function (Blueprint $table) {
             $table->id();

             $table->unsignedBigInteger('challenge_id');
             $table->foreign('challenge_id')->references('id')->on('challenge')->onDelete('cascade');

             $table->string('location');
             $table->string('main_line');
             $table->unsignedBigInteger('character_id');
             $table->foreign('character_id')->references('id')->on('character')->onDelete('cascade');
             $table->string('image');
             $table->string('content');
             $table->string('audio')->nullable();

             $table->timestamps();
         });

        Schema::create('challenge_user', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('challenge_id');
            $table->foreign('challenge_id')->references('id')->on('challenge')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('progress')->comment('%');
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_translation');
        Schema::dropIfExists('challenge');
        Schema::dropIfExists('character');
    }
}
