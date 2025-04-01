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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); // Unique identifier
            $table->string('name')->unique(); // Already indexed due to unique constraint
            $table->string('code')->unique()->index(); // Already indexed due to unique constraint
            $table->decimal('discount_value', 10, 2); // No index needed
            $table->integer('usage_limit')->nullable();
            $table->integer('used_count')->default(0);
            $table->dateTime('expires_at')->nullable()->index(); // Indexed for expiration filtering
            // $table->enum('status', ['active', 'inactive'])->default('active')->index(); // Improves filtering
            $table->boolean('status')->default(true);
            $table->string('created_date')->index();
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['name', 'code']);

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
