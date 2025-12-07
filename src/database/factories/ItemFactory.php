<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'       => \App\Models\User::factory(),
            'item_name'     => $this->faker->words(3, true),
            'brand_name'    => $this->faker->company,
            'price'         => $this->faker->numberBetween(500, 100000),
            'item_describe' => $this->faker->paragraph(),
            'category1'     => 'ファッション',
            'category2'     => '家電',
            'category3'     => 'インテリア',
            'category4'     => 'レディース',
            'category5'     => 'メンズ',
            'category6'     => 'コスメ',
            'category7'     => '本',
            'category8'     => 'ゲーム',
            'category9'     => 'スポーツ',
            'category10'    => 'キッチン',
            'category11'    => 'ハンドメイド',
            'category12'    => 'アクセサリー',
            'category13'    => 'おもちゃ',
            'category14'    => 'ベビー・キッズ',
            'condition'     => $this->faker->randomElement(['新品', '中古', '未使用に近い']),
            'image'         => $this->faker->imageUrl(640, 480, 'product', true),
        ];
    }
}
