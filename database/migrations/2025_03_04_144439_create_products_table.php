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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Auto-indexed as Primary Key
            $table->string('name')->index(); // Useful for searching by product name
            $table->string('image')->index(); // No index needed (not used in queries)
            $table->string('currency')->default('ETB')->index(); // No index needed (low cardinality)
            $table->decimal('price', 10, 2); // Indexed if frequently used for filtering/sorting
            $table->uuid('uuid')->unique(); // Unique identifier, already indexed automatically
            $table->string('slug')->unique()->index(); // Useful for SEO and searching
            // $table->enum('status', ['active', 'inactive'])->default('active')->index(); // Frequently filtered
            $table->boolean('status')->default(true);
            $table->string('created_date'); // Change to `timestamp` and index it for sorting
            $table->softDeletes(); // Automatically creates `deleted_at` column (consider indexing)
            $table->timestamps(); // Adds `created_at` and `updated_at` (Consider indexing `created_at`)
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
