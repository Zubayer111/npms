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
        Schema::create('patients_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('reference_by')->default(0);
            $table->dateTime('reference_time')->nullable();
            $table->longText('reference_note')->nullable();
            $table->string('title')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('email')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->enum('marital_status', ['Married', 'Unmarried', 'Divorced', 'Separated', 'Widowed', 'Single', 'Life Partner'])->nullable();
            $table->dateTime('dob')->nullable();
            $table->double('height')->default(0.00);
            $table->double('weight')->default(0.00);
            $table->string('bmi')->nullable();
            $table->string('address_one')->nullable();
            $table->string('address_two')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zipCode', 16)->nullable();
            $table->string('phone_number')->nullable();
            $table->text('history')->nullable();
            $table->text('employer_details')->nullable();
            $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])->nullable();
            $table->enum('economical_status', ['rich', 'middle class', 'poor'])->nullable();
            $table->enum('smoking_status', ['smoker', 'non smoker'])->nullable();
            $table->enum('alcohole_status', ['alcoholic', 'non alcoholic'])->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->enum('patient_type', ['system-patient', 'vendor-patient'])->default('system-patient');
            $table->string('profile_photo')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients_profiles');
    }
};
