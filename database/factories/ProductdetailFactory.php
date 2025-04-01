<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Template;
use App\Models\ProductTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Productdetail>
 */
class ProductdetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $is_hotdeal = $this->faker->boolean();
        if($is_hotdeal){
            $hotdeal_start = $this->faker->dateTime();
            $hotdeal_end = $this->faker->dateTime();
        }else{
            $hotdeal_start = null;
            $hotdeal_end = null;
        }

        $template_status = $this->faker->boolean();

        return [
            'product_id' => Product::factory(),
            'discount_percent' => $this->faker->randomFloat(2, 1, 30),
            'is_hotdeal' =>  $is_hotdeal,
            'hotdeal_start' => $hotdeal_start,
            'hotdeal_end' => $hotdeal_end,
            'custom_order_allowed' => $this->faker->boolean(),
            'template_status' => $template_status,
        ];
    }
}
