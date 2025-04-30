<?php
    namespace App\Services;
    use App\Models\Category;
    use App\Models\Product;



    class CategoryService
    {
        public function getAllCategories()
        {
            return Category::all();
        }
        public function getCategoriesActive()
        {
            return Category::query()->where('status', true);
        }



        




    }

