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
        Schema::create('corporates', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->index(); // Index for foreign key
            $table->string('company_name')->index(); // Frequently searched
            $table->string('contact_person')->nullable();
            $table->string('contact_email')->nullable()->unique(); // Already indexed as unique
            $table->string('contract')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable()->index(); // Might be searched
            $table->timestamp('email_verified_at')->nullable();
            $table->softDeletes(); // Enables soft delete
            $table->timestamps();
        });

    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corporates');
    }
};
