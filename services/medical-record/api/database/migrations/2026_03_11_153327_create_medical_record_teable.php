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
        Schema::create('medical_record_teable', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('maladie_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('treatement_id');
            $table->text('description');
            $table->string('pdf_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_record_teable');
    }
};
