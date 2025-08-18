<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn('full_name');
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn('full_name');
        });
    }

    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('full_name');
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->string('full_name');
        });
    }
};
