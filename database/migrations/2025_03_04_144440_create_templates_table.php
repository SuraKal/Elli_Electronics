<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->index();
            $table->text('note')->nullable();
            // $table->enum('status', ['active', 'inactive'])->default('active')->index(); // Frequently filtered
            $table->boolean('status')->default(true);
            $table->boolean('privacy')->nullable()->default(false); // Better as boolean
            $table->longText('structure')->nullable()->index(); // Stores template structure (JSON or text)
            $table->uuid('uuid')->unique(); // Unique identifier
            $table->foreignIdFor(Product::class)->nullable()->constrained()->cascadeOnDelete(); // Foreign key for product
            $table->softDeletes(); // Enables soft delete
            $table->timestamps(); // Created at & Updated at
        });

    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
