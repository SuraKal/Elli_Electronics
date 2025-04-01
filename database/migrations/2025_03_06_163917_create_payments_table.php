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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('method')->index();
            $table->string('logo')->nullable();
            $table->string('acc_name')->index();
            $table->string('acc_number')->index();
            // $table->enum('status', ['active', 'inactive'])->default('active')->index(); // Frequently filtered
            $table->boolean('status')->default(true);
            $table->uuid('uuid')->unique();
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
        Schema::dropIfExists('payments');
    }
};
