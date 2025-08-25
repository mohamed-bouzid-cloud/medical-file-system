<?php
// database/migrations/2025_08_18_000003_create_dicom_signature_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dicom_signature', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dicom_study_id');
            $table->unsignedBigInteger('doctor_id');
            $table->string('signature_hash'); // hash(file + doctor + timestamp)
            $table->timestamp('signed_at')->useCurrent();

            $table->foreign('dicom_study_id')->references('id')->on('dicom_studies')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dicom_signature');
    }
};
