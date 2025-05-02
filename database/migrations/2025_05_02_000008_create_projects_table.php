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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('mill_ref')->nullable();
            $table->string('tapis_ref')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('rep_id')->nullable()->constrained('people')->nullOnDelete();
            $table->foreignId('mill_id')->nullable()->constrained('mills')->nullOnDelete();
            $table->foreignId('airline_id')->nullable()->constrained('airlines')->nullOnDelete();
            $table->foreignId('design_firm_id')->nullable()->constrained('design_firms')->nullOnDelete();
            $table->string('style')->nullable();
            $table->string('sample_matching')->nullable();
            $table->string('project_reference')->nullable();
            $table->string('application_notes')->nullable();
            $table->string('eta')->nullable();
            $table->string('mill_to_ny_tracking')->nullable();
            $table->string('received_from_mill')->nullable();
            $table->string('ship_date')->nullable();
            $table->string('samples_sent_to')->nullable();
            $table->string('outgoing_tracking')->nullable();
            $table->string('approval_date')->nullable();
            $table->string('tapis_part_number')->nullable();
            $table->string('color_name')->nullable();
            $table->string('color_group')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
