<?php
// database/migrations/2025_08_18_000002_create_dicom_studies_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dicom_studies', function (Blueprint $table) {
            $table->id();
            $table->string('ipp'); // patient identifier
            $table->unsignedBigInteger('doctor_id');
            $table->string('file_path');
            $table->timestamps();

            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dicom_studies');
    }
};
