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
        Schema::create('productdetails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('discount_percent', 5, 2)->nullable();
            $table->boolean('is_hotdeal')->default(false);
            $table->dateTime('hotdeal_start')->nullable();
            $table->dateTime('hotdeal_end')->nullable();
            $table->boolean('custom_order_allowed')->default(false)->index();
            $table->boolean('template_status')->default(true);
            $table->text('additional_info')->nullable(); // Store any extra details if needed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productdetails');
    }
};
