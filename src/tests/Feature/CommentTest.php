<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    // 9-1_ログイン済みユーザーはコメントを送信できる
    public function test_9_1()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)
            ->post('/comment', [
                'user_id' => $user->id,
                'item_id' => $item->id,
                'comment' => 'テストコメントです',
            ]);

        $response->assertRedirect("/item/{$item->id}");

        $this->assertDatabaseHas('items_comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'テストコメントです',
        ]);
    }

    // 9-2_未ログインユーザーはコメントを送信できない
    public function test_9_2()
    {
        $item = Item::factory()->create();

        $response = $this->post('/comment', [
            'item_id' => $item->id,
            'comment' => 'テストコメントです',
        ]);

        $response->assertRedirect('/login');

        $this->assertDatabaseMissing('items_comments', [
            'item_id' => $item->id,
            'comment' => 'テストコメントです',
        ]);
    }

    // 9-3_コメントが入力されていない場合、バリデーションエラー
    public function test_9_3()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)
            ->post('/comment', [
                'user_id' => $user->id,
                'item_id' => $item->id,
                'comment' => '',
            ]);

        $response->assertSessionHasErrors('comment');
    }

    // 9-4_コメントが255字以上の場合、バリデーションエラー
    public function test_9_4()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $longComment = str_repeat('あ', 256);

        $response = $this->actingAs($user)
            ->post('/comment', [
                'user_id' => $user->id,
                'item_id' => $item->id,
                'comment' => $longComment,
            ]);

        $response->assertSessionHasErrors('comment');
    }
}
