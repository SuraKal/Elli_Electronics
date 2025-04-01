<?php

use App\Models\Order;
use App\Models\Payment;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index();
            $table->string('tx_ref')->unique()->index(); // Already indexed due to unique constraint
            $table->foreignIdFor(Order::class)->constrained()->cascadeOnDelete();
            $table->enum('status', ['unconfirmed', 'waiting', 'paid', 'declined'])->default('unconfirmed');
            $table->enum('method', ['bank','chapa','cash'])->default('bank')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
