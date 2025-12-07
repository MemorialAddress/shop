<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\UsersAdd;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    // 12-1_住所変更後の値が商品購入画面に反映される
    public function test_12_1_address_is_reflected_after_change()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        UsersAdd::create([
            'user_id' => $user->id,
            'post_code' => '111-1111',
            'address' => '旧住所',
            'building' => '旧ビル',
        ]);

        $response = $this->actingAs($user)->post("/change", [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'post_code' => '222-2222',
            'address' => '新住所',
            'building' => '新ビル',
        ]);

        $response->assertRedirect("/purchase/{$item->id}");

        $response = $this->actingAs($user)->get("/purchase/{$item->id}");

        $response->assertSee('222-2222');
        $response->assertSee('新住所');
        $response->assertSee('新ビル');
    }

    // 12-2_購入した商品に送付先住所が紐づいて登録される
    public function test_12_2_address_saved_in_purchase_table()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)->post("/purchase/address/{$item->id}", [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'post_code' => '333-3333',
            'address' => '購入時住所',
            'building' => '購入時ビル',
        ]);

        $response = $this->actingAs($user)->post('/buy', [
            'item_id' => $item->id,
            'user_id' => $user->id,
            'payment_method' => 'カード支払い',
            'purchase_post_code' => '333-3333',
            'purchase_address' => '購入時住所',
            'purchase_building' => '購入時ビル',
        ]);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'purchase_post_code' => '333-3333',
            'purchase_address' => '購入時住所',
            'purchase_building' => '購入時ビル',
        ]);
    }
}
