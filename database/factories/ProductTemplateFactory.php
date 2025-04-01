<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Template;
use App\Models\ProductTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductTemplate>
 */
class ProductTemplateFactory extends Factory
{
    protected $model = ProductTemplate::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'template_id' => Template::factory(),
            'structure' => json_encode([
                'Color' => [
                    'Red' => 'active',
                    'Blue' => 'inactive',
                    'Green' => 'active',
                    'Black' => 'inactive',
                ],
                'Size' => [
                    'Small' => 'active',
                    'Medium' => 'inactive',
                    'Large' => 'active',
                    'XL' => 'inactive',
                ],
            ]),
        ];
    }
}
