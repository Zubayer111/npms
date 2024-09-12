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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('medicine_name', 255)->unique();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('manufacturer_id');
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('group_id');
            $table->string('strength', 255);
            $table->string('description', 255)->nullable();
            $table->string('price', 255);
            $table->string('use_for', 255);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreign('manufacturer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('medicine_types')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('medicine_groups')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
