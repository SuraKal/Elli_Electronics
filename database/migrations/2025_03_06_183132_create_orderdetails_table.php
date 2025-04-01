<?php

use App\Models\Order;
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
        Schema::create('orderdetails', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->constrained()->cascadeOnDelete();
            // The property product_ordered will store the products properties and sub properties
            // in JSON format
            $table->longText('product_ordered')->nullable();
            $table->integer('quantity')->default(1);
            $table->string('currency')->default('ETB')->index(); // No index needed (low cardinality)
            $table->decimal('price', 10, 2);
            $table->decimal('amount', 10, 2);
            $table->string('coupon_used')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderdetails');
    }
};
