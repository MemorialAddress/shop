<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserAddFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'   => \App\Models\User::factory(),
            'post_code' => $this->faker->postcode(),
            'address'   => $this->faker->address(),
            'building'  => $this->faker->secondaryAddress(),
            'image'     => $this->faker->imageUrl(640, 480, 'people', true),
        ];
    }
}
