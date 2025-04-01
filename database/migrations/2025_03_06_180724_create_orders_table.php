<?php

use App\Models\User;
use App\Models\Guest;
use App\Models\Product;
use App\Models\Project;
use App\Models\Corporate;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->index(); // Already indexed due to unique constraint
            $table->foreignIdFor(Guest::class)->nullable()->constrained()->onDelete('cascade'); 
            $table->foreignIdFor(User::class)->nullable()->constrained()->onDelete('cascade'); 
            $table->foreignIdFor(Corporate::class)->nullable()->constrained()->onDelete('cascade'); 

            $table->boolean('is_project_order')->default(false); // Tracks if order is linked to a project
            $table->foreignIdFor(Project::class)->nullable()->constrained()->onDelete('cascade'); 

            $table->enum('userType', ['guest', 'customer', 'corporate'])->default('customer');

            $table->foreignIdFor(Product::class)->constrained()->onDelete('cascade');

            $table->enum('type', ['Credit', 'BePaid'])->default('BePaid');

            $table->enum('status', ['pending', 'assigned', 'cancelled', 'ontheway', 'dropped'])->default('pending');


            $table->uuid('uuid')->unique(); // Unique public identifier
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
        Schema::dropIfExists('orders');
    }
};
