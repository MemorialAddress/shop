<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    //  1-1_名前が入力されていない場合、バリデーションメッセージが表示される
    public function test_1_1()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('name');
    }

    //  1-2_メールアドレスが入力されていない場合、バリデーションメッセージが表示される
    public function test_1_2()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    //  1-3_パスワードが入力されていない場合、バリデーションメッセージが表示される
    public function test_1_3()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors('password');
    }

    //  1-4_パスワードが7文字以下の場合、バリデーションメッセージが表示される
    public function test_1_4()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'pass123',
            'password_confirmation' => 'pass123',
        ]);

        $response->assertSessionHasErrors('password');
    }

    //  1-5_パスワードが確認用パスワードと一致しない場合、バリデーションメッセージが表示される
    public function test_1_5()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different123',
        ]);

        $response->assertSessionHasErrors('password');
    }

    //  1-6_全ての項目が入力されている場合、会員情報が登録され、プロフィール設定画面に遷移される
    public function test_1_6()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);

        $response->assertRedirect('/email/verify');
    }
}
