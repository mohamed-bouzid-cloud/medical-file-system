<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('dicom_signatures', function (Blueprint $table) {
            $table->id();
    
            // Relationships
            $table->unsignedBigInteger('dicom_study_id');
            $table->foreign('dicom_study_id')->references('id')->on('dicom_studies')->onDelete('cascade');
    
            $table->unsignedBigInteger('doctor_id');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
    
            // Signature data
            $table->string('signature_hash'); // digital signature hash
            $table->string('certificate_path')->nullable(); // file path if stored locally
            $table->timestamp('signed_at')->nullable();
    
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dicom_signatures');
    }
};
