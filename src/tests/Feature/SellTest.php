<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SellTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 15_1 商品出品情報が保存できること
     */
    public function test_15_1_can_store_product()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/setSell', [
            'user_id' => $user->id,
            'category1' => '1',
            'condition' => '新品',
            'item_name' => 'テスト商品名',
            'brand_name' => 'テストブランド',
            'item_describe' => '商品の説明です',
            'price' => 1000,
            'image' => 'sample.png'
        ]);

        $response->assertRedirect('/mypage');

        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'category1' => 'ファッション',
            'condition' => '新品',
            'item_name' => 'テスト商品名',
            'brand_name' => 'テストブランド',
            'item_describe' => '商品の説明です',
            'price' => 1000,
            'image' => 'sample.png'
        ]);
    }
}
