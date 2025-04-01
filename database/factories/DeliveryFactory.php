<?php

namespace Database\Factories;

use App\Models\Courier;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Delivery>
 */
class DeliveryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $deliveryType = $this->faker->randomElement(['customerBased', 'deliveryPartner', 'indoorDelivery']);
        $courier_id = NULL;
        if($deliveryType == 'deliveryPartner'){
            $courier_id = Courier::factory()->create();
        }
        return [
            'order_id' => Order::factory()->create(),
            'deliveryType' => $deliveryType,
            'courier_id' => $courier_id
        ];
    }
}
