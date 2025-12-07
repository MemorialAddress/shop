<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 11-1_小計画面で変更が反映される
     */
    public function test_11_1()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->get("/purchase/{$item->id}");

        $response->assertStatus(200);

        $response->assertSee('name="payment_method"', false);
        $response->assertSee('id="paymentSelect"', false);

        $response->assertSee('id="selectedPayment"', false);
    }
}
