<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {     
        Schema::create('requirements', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // e.g. "po", "preliminary_tds"
            $table->string('label');
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('requirements');
    }
};
