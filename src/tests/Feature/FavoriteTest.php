<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Favorite;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    // 8-1_いいねを登録できること
    public function test_8_1()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)
            ->post("/item/{$item->id}", [
                'user_id' => $user->id,
                'item_id' => $item->id,
            ])
            ->assertStatus(302);

        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    // 8-2_いいね済みの場合、アイコンが変化すること
    public function test_8_2()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        Favorite::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->get("/item/{$item->id}");
        $response->assertSee('star_good.png');
    }

    // 8-3_いいねを再度押すと解除できること
    public function test_8_3()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        Favorite::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user)
            ->post("/item/{$item->id}", [
                'user_id' => $user->id,
                'item_id' => $item->id,
            ]);

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }
}
