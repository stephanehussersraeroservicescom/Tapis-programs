<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // PartNumberRequirement pivot table
        Schema::create('part_number_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('part_number_id')->constrained('part_numbers')->onDelete('cascade');
            $table->foreignId('requirement_id')->constrained('requirements')->onDelete('cascade');
            $table->boolean('waived')->default(false);
            $table->boolean('completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('part_number_requirements');
    }
};
