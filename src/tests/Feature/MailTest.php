<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CustomVerifyEmail;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class MailTest extends TestCase
{
    use RefreshDatabase;

    // 16_1 会員登録後、認証メールが送信される
    public function test_registration_sends_verification_email()
    {
        Notification::fake();

        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $user = User::where('email', 'test@example.com')->first();

        Notification::assertSentTo($user, CustomVerifyEmail::class);
    }

    // 16_2 メール認証誘導画面で「認証はこちらから」ボタンを押下するとメール認証サイトに遷移する
    public function test_verification_page_has_verify_button()
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get('/email/verify');

        $response->assertStatus(200);
        $response->assertSee('認証はこちらから');
        $response->assertSee("http://localhost:8025");

    }

    // 16_3 メール認証完了でプロフィール設定画面に遷移する
    public function test_email_verification_redirects_to_profile_setting()
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify', // ルート名
            Carbon::now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertRedirect('/setProfile');

        $this->assertNotNull($user->fresh()->email_verified_at);
    }
}
