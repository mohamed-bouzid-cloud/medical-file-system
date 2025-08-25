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
    Schema::table('dicom_studies', function (Blueprint $table) {
        $table->string('file_path')->after('study_uid');
    });
}

public function down()
{
    Schema::table('dicom_studies', function (Blueprint $table) {
        $table->dropColumn('file_path');
    });
}

};
