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
        Schema::create('couriers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); // Ensures unique identifier
            $table->string('name')->index(); // Indexing for name search
            $table->string('contact_phone'); // If phone is frequently searched
            $table->string('contact_email')->unique(); // Ensures uniqueness, automatically indexed
            $table->string('address')->nullable();
            $table->string('logo')->nullable();
            $table->text('description')->nullable();
            // $table->enum('status', ['active', 'inactive'])->default('active')->index(); // Improves filtering
            $table->boolean('status')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->string('created_date')->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('couriers');
    }
};
