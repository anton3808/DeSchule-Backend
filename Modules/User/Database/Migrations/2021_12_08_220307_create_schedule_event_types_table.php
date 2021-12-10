<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleEventTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_event_types', function (Blueprint $table) {
            $table->id();

            $table->string('slug')->unique();

            $table->timestamps();
        });

        Schema::create('schedule_event_type_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schedule_event_type_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->unique(['schedule_event_type_id', 'locale'], 'type_id_locale_unique');
            $table->foreign('schedule_event_type_id')->references('id')->on('schedule_event_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule_event_type_translations');
        Schema::dropIfExists('schedule_event_types');
    }
}
