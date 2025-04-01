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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); // Already indexed as unique
            $table->string('name')->index(); // Index for searching users by name
            $table->string('email')->unique(); // Already indexed as unique
            $table->string('phone')->nullable()->unique(); // Already indexed as unique
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active')->index(); // Index for frequent filtering
            $table->timestamp('email_verified_at')->nullable(); // No index needed (rarely queried directly)
            $table->string('password'); // No index needed
            $table->string('profile_picture')->nullable(); // No index needed
            $table->rememberToken();
            $table->string('created_date');
            $table->softDeletes(); // Enables soft delete (Consider indexing if frequently queried)
            $table->timestamps(); // Adds created_at and updated_at (Consider indexing `created_at`)
        });


        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
