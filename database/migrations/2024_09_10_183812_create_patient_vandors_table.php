<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patient_vandors', function (Blueprint $table) {
            $table->id();
            $table->string('token', 32)->default(Str::random(32));
            $table->string('secret_key', 64)->default(Str::random(64));
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('fax')->nullable();
            $table->text('address');
            $table->string('contact_person');
            $table->enum('status', ['active', 'inactive'])->default('active');
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
        Schema::dropIfExists('patient_vandors');
    }
};
