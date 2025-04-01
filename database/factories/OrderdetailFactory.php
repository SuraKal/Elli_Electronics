<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orderdetail>
 */
class OrderdetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Check if 'order_id' is provided, otherwise create a new Order
        // $order = $this->attributes['order_id'] ?? Order::factory()->create();

        // if($this->attributes['order_id']){
        //     $order = $this->attributes['order_id'];
        // }else{
        //     $order = Order::factory()->create();
        // }


        // Check if 'order_id' is provided in the attributes

        $order = Order::first();


        $product_ordered = $order->product->template_status ? $order->product->template->structure : NULL;
        $price = $order->product->price; // Random price between 10 and 500



        $quantity = $this->faker->numberBetween(1, 10); // Random quantity between 1 and 10
        $amount = $price * $quantity; // Calculate total

        return [
            'order_id' => '', // Ensure it is always set
            'product_ordered' => $product_ordered,
            'quantity' => $quantity,
            'price' => $price,
            'amount' => $amount
        ];
    }
    
    // public function definition(): array
    // {
    //     // Check if 'order_id' is provided, otherwise create a new Order
    //     $order = $this->attributes['order_id'] ?? Order::factory()->create();

    //     $product_ordered = $order->product->template_status ? $order->product->template->structure : NULL;
    //     $price = $order->product->price; // Random price between 10 and 500
    //     $quantity = $this->faker->numberBetween(1, 10); // Random quantity between 1 and 10
    //     $amount = $price * $quantity; // Calculate total

    //     return [
    //         'order_id' => $order->id, // Ensure it is always set
    //         'product_ordered' => $product_ordered,
    //         'quantity' => $quantity,
    //         'price' => $price,
    //         'amount' => $amount
    //     ];
    // }

}
