<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package', function (Blueprint $table) {
            $table->id();

            $table->string('image')->nullable();
            $table->string('price')->nullable();
            $table->string('type')->comment('course/tariff');
            $table->string('status')->default('active');

            $table->unsignedBigInteger('available_in_tariff_id')->nullable();
            $table->foreign('available_in_tariff_id')->references('id')->on('package')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('package_translation', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('package_id');
            $table->foreign('package_id')->references('id')->on('package')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('title');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('package');
    }
}
