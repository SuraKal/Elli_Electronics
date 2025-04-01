<?php

namespace Database\Seeders;

use App\Models\ProductTemplate;
use App\Models\Tag;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Courier;
use App\Models\Product;
use App\Models\Category;
use App\Models\Template;
use App\Models\Corporate;
use App\Models\Image;
use App\Models\Productdetail;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Courier::factory(10)->create();

        Coupon::factory(10)->create();

        User::factory(3)->create();

        Category::factory(2)->create();

        Tag::factory(2)->create();

        Product::factory(3)->create()->each(function ($product) {
            // Create a corporate for each user
            $detail = Productdetail::factory()->create([
                'product_id' => $product->id,
            ]);

            $template = ProductTemplate::factory()->create([
                'product_id' => $product->id,
            ]);

            $image = Image::factory(3)->create([
                'product_id' => $product->id,
            ]);
        });



    }
}
