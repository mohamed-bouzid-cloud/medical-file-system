<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add user_id to patients
        Schema::table('patients', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->unique()->after('ipp');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Add user_id to doctors
        Schema::table('doctors', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->unique()->after('id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
