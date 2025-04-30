<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

        protected static function boot()
    {
        parent::boot();

        // Automatically generate UUID when creating a new user
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }

            // Generate Slug
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    protected $hidden = [
        'id'
    ];


    public function products(){
        return $this->belongsToMany(Product::class);
    }

    public function productsActive(){
        return $this->products()->where('status', true);
    }
    public function productsCount()
    {
        return $this->products()->count(); // Correctly counts products
    }

    public function hotdealproducts()
    {
        return $this->products() // Use the relationship
            ->with('detail')
            ->where('status', true)
            ->whereHas('detail', function ($query) {
                $query->where('is_hotdeal', true)
                    ->whereNotNull('hotdeal_end')
                    ->whereDate('hotdeal_end', '>=', now());
            })
            ->get();
    }

                public function topSellingProducts()
            {
                return Order::select('product_id', DB::raw('COUNT(product_id) as order_count'))
                    ->groupBy('product_id') // Group by product ID
                    ->orderByDesc('order_count') // Sort by most orders
                    ->take(10) // Limit to top 10 products
                    ->get();
            }





}
