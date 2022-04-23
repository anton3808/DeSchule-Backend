<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_option', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('package_id');
            $table->foreign('package_id')->references('id')->on('package')->onDelete('cascade');
            $table->string('type')->comment('check_mark/cross');
            $table->string('status')->default('active');

            $table->timestamps();
        });

        Schema::create('package_option_translation', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('package_option_id');
            $table->foreign('package_option_id')->references('id')->on('package_option')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_option_translation');
        Schema::dropIfExists('package_option');
    }
}
