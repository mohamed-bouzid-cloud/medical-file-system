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
        Schema::create('conditions', function (Blueprint $table) {
            $table->id();
            $table->string('ipp');
            $table->string('condition_name');
            $table->date('diagnosed_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        
            $table->foreign('ipp')->references('ipp')->on('patients')->onDelete('cascade');
        });
        
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conditions');
    }
};
