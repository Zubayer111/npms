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
        Schema::create('patient_advice', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients_profiles')->onDelete('cascade');
            $table->text('advice');
            $table->text('investigation');
            $table->text('disease_description');
            $table->text('clinical_diagnosis');
            $table->string('next_meeting_date', 100)->nullable();
            $table->string('next_meeting_indication', 100)->nullable();
            $table->text('guide_to_prescription')->nullable();
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
        Schema::dropIfExists('patient_advice');
    }
};
