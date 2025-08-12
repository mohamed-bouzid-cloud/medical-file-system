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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('ipp');
            $table->string('doctor_name')->nullable();
            $table->dateTime('appointment_date');
            $table->text('notes')->nullable();
            $table->string('status')->default('Scheduled');
            $table->timestamps();
        
            $table->foreign('ipp')->references('ipp')->on('patients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
