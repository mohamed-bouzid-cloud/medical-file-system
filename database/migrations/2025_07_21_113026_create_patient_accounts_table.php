<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('patient_accounts', function (Blueprint $table) {
        $table->string('ipp')->unique();      // same IPP as in patients table
        $table->foreign('ipp')->references('ipp')->on('patients')->onDelete('cascade');
        $table->string('email')->unique();
        $table->string('password');          // hashed
        $table->rememberToken();             // for "stay logged in"
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_accounts');
    }
};
