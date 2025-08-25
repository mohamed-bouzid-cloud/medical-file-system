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
        Schema::create('dicom_studies', function (Blueprint $table) {
            $table->id();
            
            // Relationships
            $table->string('patient_ipp'); // references patients.ipp
            $table->foreign('patient_ipp')->references('ipp')->on('patients')->onDelete('cascade');
    
            $table->unsignedBigInteger('doctor_id'); // references doctors.id
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
    
            // DICOM metadata
            $table->string('study_uid')->unique(); // Orthanc Study Instance UID
            $table->string('orthanc_id')->nullable(); // Orthanc internal ID (UUID)
            $table->string('modality')->nullable(); // CT, MRI, US...
            $table->date('study_date')->nullable();
            $table->text('description')->nullable();
    
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dicom_studies');
    }
};
