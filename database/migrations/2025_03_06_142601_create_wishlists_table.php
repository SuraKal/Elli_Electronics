<?php

use App\Models\Corporate;
use App\Models\Guest;
use App\Models\Product;
use App\Models\Project;
use App\Models\User;
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
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Guest::class)->nullable()->constrained()->onDelete('cascade'); 
            $table->foreignIdFor(User::class)->nullable()->constrained()->onDelete('cascade'); 
            $table->foreignIdFor(Corporate::class)->nullable()->constrained()->onDelete('cascade'); 

            $table->boolean('is_project_wish')->default(false); // Tracks if order is linked to a project
            $table->foreignIdFor(Project::class)->nullable()->constrained()->onDelete('cascade'); 

            $table->enum('userType', ['guest', 'customer', 'corporate'])->default('customer');
            $table->foreignIdFor(Product::class)->constrained()->onDelete('cascade'); 


            $table->uuid('uuid')->unique(); // Unique public identifier
            $table->string('created_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
