<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\UsersAdd;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    //13_1 必要な情報が取得できる（プロフィール画像、ユーザー名、出品した商品一覧、購入した商品一覧）
    public function test_13_1()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー'
        ]);

        $userAdd = UsersAdd::create([
            'user_id' => $user->id,
            'post_code' => '123-4567',
            'address' => '東京都千代田区',
            'building' => 'テストビル',
            'image' => 'test.png'
        ]);

        $response = $this->actingAs($user)->get('/mypage/profile');

        $response->assertStatus(200);
        $response->assertSee('value="' . $user->name . '"', false);
        $response->assertSee('value="' . $userAdd->post_code . '"', false);
        $response->assertSee('value="' . $userAdd->address . '"', false);
        $response->assertSee('value="' . $userAdd->building . '"', false);
        $response->assertSee('/storage/image/profile/' . $userAdd->image);
    }

    //14_1 変更項目が初期値として過去設定されていること（プロフィール画像、ユーザー名、郵便番号、住所）
    public function test14_1()
    {
        //Storage::fake('public');

        $user = User::factory()->create();
        $userAdd = UsersAdd::create([
            'user_id' => $user->id,
            'post_code' => '111-1111',
            'address' => '旧住所',
            'building' => '旧ビル',
            'image' => 'old.png'
        ]);

        //$file = UploadedFile::fake()->image('new_profile.png');

        $response = $this->actingAs($user)->post('/setProfile', [
            'user_id' => $user->id,
            'name' => '更新ユーザー',
            'post_code' => '999-9999',
            'address' => '新住所',
            'building' => '新ビル',
            'image' => 'new.png'
        ]);

        $response->assertRedirect('/mypage/profile');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => '更新ユーザー'
        ]);

        // users_adds テーブルに反映
        $this->assertDatabaseHas('users_adds', [
            'user_id' => $user->id,
            'post_code' => '999-9999',
            'address' => '新住所',
            'building' => '新ビル',
            'image' => 'new.png'
        ]);
    }

}
