<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Requirement uploads (optional, file tracking per requirement)
        Schema::create('requirement_uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('part_number_requirement_id')->constrained()->onDelete('cascade');
            $table->string('file_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requirement_uploads');
    }
};
