<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;
use App\Models\Purchase;

class PurchaseController extends Controller
{
/*
    public function checkoutSuccess(Request $request)
    {
        $session_id = $request->query('session_id');

        Stripe::setApiKey(env('STRIPE_SECRET')); // .env に設定しておく
        // Stripe Checkout セッションを取得
        $session = CheckoutSession::retrieve($session_id);

        // metadata から購入情報を取得
        $purchaseData = [
            'item_id' => $session->metadata->item_id,
            'user_id' => $session->metadata->user_id,
            'payment_method' => 'カード支払い',
            'purchase_post_code' => $session->metadata->post_code,
            'purchase_address' => $session->metadata->address,
            'purchase_building' => $session->metadata->building,
        ];

        // Purchase レコードを作成
        Purchase::create($purchaseData);

        // 完了画面へリダイレクト
        return redirect()->route('items.index')->with('message', '購入が完了しました');
    }

    // Webhook用
    public static function handlePaymentIntentSucceeded($paymentIntent)
    {
        // metadata がセットされていれば取得
        $metadata = $paymentIntent->metadata;

        if (!empty($metadata)) {
            $purchaseData = [
                'item_id' => $metadata->item_id ?? null,
                'user_id' => $metadata->user_id ?? null,
                'payment_method' => 'カード支払い',
                'purchase_post_code' => $metadata->post_code ?? null,
                'purchase_address' => $metadata->address ?? null,
                'purchase_building' => $metadata->building ?? null,
            ];

            Purchase::create($purchaseData);
        }

        error_log("PaymentIntent processed: " . $paymentIntent->id);
    }
*/
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (\Exception $e) {
            \Log::error('Stripe webhook error: ' . $e->getMessage());
            return response('Webhook error', 400);
        }

        if ($event->type === 'payment_intent.succeeded') {
            $paymentIntent = $event->data->object;
            $metadata = $paymentIntent->metadata;

            $paymentMethodType = $paymentIntent->payment_method_types[0] ?? 'unknown';

            // 日本語名に変換
            switch ($paymentMethodType) {
                case 'card':
                    $paymentMethodName = 'カード支払い';
                    break;
                case 'konbini':
                    $paymentMethodName = 'コンビニ払い';
                    break;
                default:
                    $paymentMethodName = $paymentMethodType; // そのまま保存
            }

            Purchase::create([
                'item_id' => $metadata->item_id ?? null,
                'user_id' => $metadata->user_id ?? null,
                'payment_method' => $paymentMethodName,
                'purchase_post_code' => $metadata->post_code ?? null,
                'purchase_address' => $metadata->address ?? null,
                'purchase_building' => $metadata->building ?? null,
            ]);
        }

        return response('OK', 200);
    }
}