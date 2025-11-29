<?php

require_once __DIR__ . '/../vendor/autoload.php';
//require_once __DIR__ . '/../secrets.php';

$stripeSecretKey = 'REMOVED';
\Stripe\Stripe::setApiKey($stripeSecretKey);
header('Content-Type: application/json');

$amount = isset($_GET['amount']) ? (int)$_GET['amount'] : null;
$itemId   = $_GET['item_id'] ?? null;
$userId   = $_GET['user_id'] ?? null;
$postCode = $_GET['post_code'] ?? '';
$address  = $_GET['address'] ?? '';
$building = $_GET['building'] ?? '';
$selectedPayment = $_GET['payment_method'] ?? 'カード支払い';

if (!$amount) {
  http_response_code(400);
  echo json_encode(['error' => 'amount required']);
  exit;
}

$paymentMethods = ($selectedPayment === 'コンビニ払い') ? ['konbini'] : ['card'];

$checkout_session = \Stripe\Checkout\Session::create([
  'payment_method_types' => $paymentMethods,
  'line_items' => [[
    'price_data' => [
      'currency' => 'jpy',
      'product_data' => ['name' => 'Dynamic Payment'],
      'unit_amount' => $amount,
    ],
    'quantity' => 1,
  ]],
  'mode' => 'payment',

    'success_url' => 'http://localhost',
    'payment_intent_data' => [
        'metadata' => [
            'item_id'   => $itemId,
            'user_id'   => $userId,
            'post_code' => $postCode,
            'address'   => $address,
            'building'  => $building,
        ]
    ],
]);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);