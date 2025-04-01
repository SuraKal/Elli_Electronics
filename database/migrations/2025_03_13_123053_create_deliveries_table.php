<?php

use App\Models\Courier;
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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            // customerBased if customer personally took the order
            // deliveryPartner if a delivery company took the delivery
            // indoorDelivery if the admin itself sent guys to pick give the package 
            $table->foreignIdFor(Order::class)->constrained()->cascadeOnDelete();
            $table->enum('deliveryType', ['customerBased', 'deliveryPartner', 'indoorDelivery'])->default('customerBased')->nullable()->default('customerBased');

            $table->foreignIdFor(Courier::class)
                    ->nullable() // Must come before constrained()
                    ->default(NULL) // Must come before constrained()
                    ->constrained()
                    ->onDelete('set null'); // Valid action
            $table->text('additional_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
