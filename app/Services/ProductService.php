<?php
    namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;



    class ProductService
    {
        public function getAllProducts()
        {
            return Product::all();
        }

        public function getProductsActive()
        {
            return Product::query()->where('status', true);
        }
        
        public function getProductsActive2()
        {
            return Product::where('status', true)->get();
        }


        public function hotdealproducts()
        {
            return Product::with('detail') // Eager load details
                ->where('status', true)
                ->whereHas('detail', function ($query) {
                    $query->where('is_hotdeal', true)
                        ->whereNotNull('hotdeal_end')
                        ->whereDate('hotdeal_end', '>=', now());
                })
                ->get();
        }

        // public function topSellingProducts()
        // {
        //     return Product::withCount('orders as order_count') // Count orders per product
        //         ->orderByDesc('order_count') // Sort by most orders
        //         ->take(10) // Limit to top 10 products
        //         ->get();
        // }

            public function topSellingProducts()
            {
                return Order::select('product_id', DB::raw('COUNT(product_id) as order_count'))
                    ->groupBy('product_id') // Group by product ID
                    ->orderByDesc('order_count') // Sort by most orders
                    ->take(10) // Limit to top 10 products
                    ->get();
            }

            public function getTopSellingProductInstances()
            {
                // Step 1: Get the product IDs and order counts
                $topProducts = $this->topSellingProducts();

                // Step 2: Extract product IDs
                $productIds = $topProducts->pluck('product_id')->toArray();

                // Step 3: Fetch full Product instances
                $products = Product::whereIn('id', $productIds)
                    ->get()
                    ->keyBy('id'); // Index products by ID for efficient lookups

                // Step 4: Attach order counts to each product
                return $topProducts->map(function ($item) use ($products) {
                    if ($product = $products->get($item->product_id)) {
                        $product->order_count = $item->order_count; // Attach order count
                        return $product;
                    }
                    return null; // Handle cases where the product is deleted
                })->filter(); // Remove null entries (deleted products)
            }


        public function getTemplateStructure($product)
        {
            return optional($product->template->first())->structure ?? [];
        }



    }
