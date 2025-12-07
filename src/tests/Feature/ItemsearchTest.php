<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Item;
use App\Models\Favorite;

class ItemSearchTest extends TestCase
{
    use RefreshDatabase;

    //  6-1_「商品名」で部分一致検索ができる
    public function test_6_1()
    {
        $user = User::factory()->create();

        $item1 = Item::factory()->create(['item_name' => '赤いシャツ']);
        $item2 = Item::factory()->create(['item_name' => '青いシャツ']);
        $item3 = Item::factory()->create(['item_name' => '緑のズボン']);

        $response = $this->actingAs($user)->get('/?keyword=シャツ');

        $response->assertStatus(200);

        $response->assertSee($item1->item_name);
        $response->assertSee($item2->item_name);

        $response->assertDontSee($item3->item_name);
    }

    //  6-2_検索状態がマイリストでも保持されている
    public function test_6_2()
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();

        $item1 = Item::factory()->create(['item_name' => '赤いシャツ', 'user_id' => $seller->id]);
        $item2 = Item::factory()->create(['item_name' => '青いシャツ', 'user_id' => $seller->id]);
        $item3 = Item::factory()->create(['item_name' => '緑のズボン', 'user_id' => $seller->id]);

        Favorite::factory()->create(['user_id' => $user->id, 'item_id' => $item1->id]);
        Favorite::factory()->create(['user_id' => $user->id, 'item_id' => $item3->id]);

        $response = $this->actingAs($user)->get('/?tab=mylist&keyword=シャツ');

        $response->assertStatus(200);

        $response->assertSee($item1->item_name);
        $response->assertDontSee($item2->item_name);
        $response->assertDontSee($item3->item_name);
    }
}
