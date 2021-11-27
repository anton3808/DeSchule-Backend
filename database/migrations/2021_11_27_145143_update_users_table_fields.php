<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('surname');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('login')->after('id')->nullable()->unique();

            $table->string('name')->after('login');
            $table->string('surname')->nullable()->after('name');

            $table->date('birthday')->nullable()->after('surname');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('login');
            $table->dropColumn('name');
            $table->dropColumn('surname');
            $table->dropColumn('birthday');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
            $table->string('surname')->nullable()->after('name');
        });
    }
}
