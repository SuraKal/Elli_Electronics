<?php
    namespace App\Services;
    use App\Models\Product;



    class ProductService
    {
        public function getAllProducts()
        {
            return Product::all();
        }
        public function getProductsActive()
        {
            return Product::where('status', true)->get();
        }
    }

