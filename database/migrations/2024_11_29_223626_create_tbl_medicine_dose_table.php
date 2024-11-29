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
        Schema::create('tbl_medicine_dose', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('medicine_type')->default(1);
            $table->string('dose_name', 250);
            $table->dateTime('updated_at');
            $table->dateTime('created_at');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamp('deleted_at')->useCurrent()->useCurrentOnUpdate();
            $table->integer('deleted_by');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_medicine_dose', function (Blueprint $table) {
            //
        });
    }
};
