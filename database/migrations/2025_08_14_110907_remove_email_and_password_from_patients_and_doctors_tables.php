<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn(['email', 'password']);
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn(['email', 'password']);
        });
    }

    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('email')->unique();
            $table->string('password');
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->string('email')->unique();
            $table->string('password');
        });
    }
};
