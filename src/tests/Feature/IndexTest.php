<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class IndexTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    //  4-1_全商品を取得できること
    public function test_4_1()
    {
        $items = Item::factory()->count(5)->create();
        $response = $this->get(route('items.index'));
        $response->assertStatus(200);

        foreach ($items as $item) {
            $response->assertSee($item->item_name);
        }
    }

    //  4-2_購入済み商品は「Sold」と表示される
    public function test_4_2()
    {
        $item = Item::factory()->create();

        Purchase::factory()->create([
            'item_id' => $item->id,
        ]);

        $response = $this->get('/');

        $response->assertSee('Sold');
    }

    //  4-3_自分が出品した商品は表示されない
    public function test_4_3()
    {
        $user = User::factory()->create();

        $myItem = Item::factory()->create([
            'user_id' => $user->id,
            'item_name' => 'My Product',
        ]);

        $otherItem = Item::factory()->create([
            'item_name' => 'Other Product',
        ]);

        $response = $this->actingAs($user)->get(route('items.index'));
        $response->assertStatus(200);
        $response->assertDontSee('My Product');
        $response->assertSee('Other Product');
    }
}
