<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    //  2-1_メールアドレスが入力されていない場合、バリデーションメッセージが表示される
    public function test_2_1()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    //  2-2_パスワードが入力されていない場合、バリデーションメッセージが表示される
    public function test_2_2()
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors('password');
    }

    //  2-3_入力情報が間違っている場合、バリデーションメッセージが表示される
    public function test_2_3()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('correctpassword'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        // Laravelの標準エラーメッセージを確認
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    //  2-4_正しい情報が入力された場合、ログイン処理が実行される
    public function test_2_4()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }
}
