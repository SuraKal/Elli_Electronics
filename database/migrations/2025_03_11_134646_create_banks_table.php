<?php

use App\Models\Payment;
use App\Models\Transaction;
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
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Transaction::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Payment::class)->nullable()->constrained()->cascadeOnDelete();
            $table->string('transaction_acccount_name')->nullable();
            $table->string('transaction_acccount_number')->nullable();
            $table->string('transaction_recipt')->nullable();
            $table->string('transaction_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banks');
    }
};
