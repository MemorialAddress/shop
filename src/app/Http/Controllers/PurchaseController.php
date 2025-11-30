<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;
use App\Models\Purchase;

class PurchaseController extends Controller
{
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