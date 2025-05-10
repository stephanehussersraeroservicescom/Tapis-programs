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
        Schema::create('part_number_treatment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('part_number_id')->constrained()->onDelete('cascade');
            $table->foreignId('treatment_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('part_number_treatment', function (Blueprint $table) {
            $table->dropForeign(['part_number_id']);
            $table->dropForeign(['treatment_id']);
        });
    
        Schema::dropIfExists('part_number_treatment');
    }
};
