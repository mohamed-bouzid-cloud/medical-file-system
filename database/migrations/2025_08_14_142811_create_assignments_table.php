<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->string('patient_ipp'); // IPP from patients table
            $table->timestamps();

            // Foreign Keys
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->foreign('patient_ipp')->references('ipp')->on('patients')->onDelete('cascade');

            // Avoid duplicate assignments
            $table->unique(['doctor_id', 'patient_ipp']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
