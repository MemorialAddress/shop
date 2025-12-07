<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    // 10-1 「購入する」ボタンを押下すると購入が完了する
    public function test_10_1()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post('/buy', [
            'item_id'            => $item->id,
            'user_id'            => $user->id,
            'payment_method'     => 'カード払い',
            'purchase_post_code' => '111-2222',
            'purchase_address'   => '東京都',
            'purchase_building'  => 'ビル101',
        ]);

        $response->assertRedirect("/");

    }

    // 10-2 購入済み商品は一覧で「SOLD」と表示される
    public function test_10_2()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        Purchase::create([
            'item_id'            => $item->id,
            'user_id'            => $user->id,
            'payment_method'     => 'カード払い',
            'purchase_post_code' => '111-2222',
            'purchase_address'   => '東京都',
            'purchase_building'  => 'ビル101',
        ]);

        $response = $this->get('/');

        $response->assertSee('Sold');
    }

    // 10-3 マイページ 購入した商品一覧に表示される
    public function test_10_3()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        Purchase::create([
            'item_id'            => $item->id,
            'user_id'            => $user->id,
            'payment_method'     => 'カード払い',
            'purchase_post_code' => '111-2222',
            'purchase_address'   => '東京都',
            'purchase_building'  => 'ビル101',
        ]);

        $response = $this->actingAs($user)->get('/mypage?page=buy');

        $response->assertSee($item->item_name);
    }
}
