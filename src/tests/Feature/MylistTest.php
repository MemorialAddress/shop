<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Item;
use App\Models\Favorite;
use App\Models\Purchase;
use Illuminate\Support\Facades\Hash;

class MyListTest extends TestCase
{
    use RefreshDatabase;

    //  5-1_いいねした商品だけが表示される
    public function test_5_1()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $likedItems = Item::factory()->count(3)->create(['user_id' => $otherUser->id]);
        foreach ($likedItems as $item) {
            Favorite::factory()->create([
                'user_id' => $user->id,
                'item_id' => $item->id
            ]);
        }

        $unlikedItems = Item::factory()->count(2)->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertStatus(200);

        foreach ($likedItems as $item) {
            $response->assertSee($item->item_name);
        }

        foreach ($unlikedItems as $item) {
            $response->assertDontSee($item->item_name);
        }
    }

    //  5-2_購入済み商品は「Sold」と表示される
    public function test_5_2()
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();

        $item = Item::factory()->create(['user_id' => $seller->id]);

        Favorite::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id
        ]);

        Purchase::factory()->create([
            'user_id' => User::factory()->create()->id,
            'item_id' => $item->id
        ]);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertStatus(200);

        $response->assertSee($item->item_name);
        $response->assertSee('Sold');
    }

    //  5-3_未認証の場合は何も表示されない
    public function test_5_3()
    {
        $item = Item::factory()->create();

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);

        $response->assertDontSee($item->item_name);
    }
}
