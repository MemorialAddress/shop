<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class Items_commentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'item_id' => \App\Models\Item::factory(),
            'user_id' => \App\Models\User::factory(),
            'comment' => $this->faker->sentence(),
        ];
    }
}
