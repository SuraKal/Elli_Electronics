<?php

use App\Models\User;
use App\Models\Guest;
use App\Models\Corporate;
use App\Models\Order;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Guest::class)->nullable()->constrained()->onDelete('cascade'); 
            $table->foreignIdFor(User::class)->nullable()->constrained()->onDelete('cascade'); 

            $table->foreignIdFor(Order::class)->nullable()->constrained()->onDelete('cascade'); 
            
            $table->enum('userType', ['guest', 'customer'])->default('customer');

            $table->string('email')->email();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('tax_id')->nullable();

            $table->string('address')->nullable();
            $table->string('appartment')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('zip')->nullable();

            $table->uuid('uuid')->unique(); // Unique public identifier
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};
