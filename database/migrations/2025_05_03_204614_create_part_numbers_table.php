<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('part_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('tapis_ref')->nullable();
            $table->unsignedBigInteger('rep_id')->nullable();
            $table->unsignedBigInteger('airline_id')->nullable();
            $table->string('application')->nullable();
            $table->string('tapis_part_number')->nullable();
            $table->string('color_name')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('part_numbers');
    }
};