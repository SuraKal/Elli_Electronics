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
            $table->uuid('uuid')->unique(); // Unique public identifier
            $table->foreignId('corporate_id')->constrained('corporates')->onDelete('cascade'); // Foreign key index
            $table->string('name')->index(); // Project name index for search
            $table->text('description')->nullable(); 
            $table->enum('status', ['pending', 'approved', 'in-progress', 'declined', 'completed'])->index(); // Filtering
            $table->string('created_date');
            $table->softDeletes();
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
