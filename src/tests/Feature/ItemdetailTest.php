<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Item;
use App\Models\Favorite;
use App\Models\Items_comment;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;

    //  7-1_必要な情報が表示される（画像、商品名、ブランド名、価格、いいね数、コメント数、商品説明、商品情報、コメントユーザー・内容）
    public function test_7_1()
    {
        $user = User::factory()->create();
        $commentUser = User::factory()->create();

        $item = Item::factory()->create([
            'item_name' => 'テスト商品',
            'brand_name' => 'ブランドA',
            'price' => 1000,
            'item_describe' => '商品説明です',
            'category1' => 'ファッション',
            'category2' => 'シャツ',
            'condition' => '新品',
            'image' => 'test.jpg'
        ]);

        Favorite::factory()->create(['user_id' => $user->id, 'item_id' => $item->id]);

        $comment = Items_comment::factory()->create([
            'user_id' => $commentUser->id,
            'item_id' => $item->id,
            'comment' => 'コメント内容です'
        ]);

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);

        $response->assertSee($item->item_name);
        $response->assertSee($item->brand_name);
        $formattedPrice = number_format($item->price);
        $response->assertSee($formattedPrice);
        $response->assertSee($item->item_describe);
        $response->assertSee('新品');
        $response->assertSee('ファッション');
        $response->assertSee('シャツ');
        $response->assertSee('1'); // いいね数
        $response->assertSee('1'); // コメント数
        $response->assertSee($commentUser->name);
        $response->assertSee($comment->comment);
        $response->assertSee($item->image);
    }

    //  7-2_複数選択されたカテゴリが表示されているか
    public function test_7_2()
    {
        $item = Item::factory()->create([
            'category1' => 'ファッション',
            'category2' => 'シャツ',
            'category3' => 'メンズ'
        ]);

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);

        $response->assertSee('ファッション');
        $response->assertSee('シャツ');
        $response->assertSee('メンズ');
    }
}
