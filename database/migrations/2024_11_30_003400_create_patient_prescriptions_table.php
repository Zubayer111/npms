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
        Schema::create('patient_prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients_profiles')->onDelete('cascade');
            $table->integer('patient_id_reading')->nullable();
            $table->integer('parameter_id')->nullable();
            $table->bigInteger('prescription_id')->nullable();
            $table->integer('parameter_value')->nullable();
            $table->string('medicine_name', 255)->nullable();
            $table->string('dose', 250)->nullable();
            $table->text('cust_dose')->nullable();
            $table->string('duration', 250)->nullable();
            $table->string('duration_unit', 250)->nullable();
            $table->string('instruction', 255);
            $table->softDeletes();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_prescriptions');
    }
};
