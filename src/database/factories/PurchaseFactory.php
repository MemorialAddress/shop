<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'item_id'             => \App\Models\Item::factory(),
            'user_id'             => \App\Models\User::factory(),
            'payment_method'      => 'カード払い',
            'purchase_post_code'  => $this->faker->postcode(),
            'purchase_address'    => $this->faker->address(),
            'purchase_building'   => $this->faker->secondaryAddress(),
        ];
    }
}
