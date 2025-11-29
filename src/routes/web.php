<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UsersAddController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Events\Verified;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\PurchaseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [ItemController::class, 'index'])->name('items.index');

Route::get('/item/{id}', [ItemController::class, 'itemDetail']);


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/?tab=mylist', [ItemController::class, 'mylist']);
    Route::get('/setProfile', [UsersAddController::class, 'setProfile'])->name('profile.set');
    Route::post('/setProfile', [UsersAddController::class, 'store']);
    Route::post('/item/{id}', [ItemController::class, 'good']);
    Route::post('/comment', [ItemController::class, 'comment']);
    Route::post('/purchase/{item_id}', [ItemController::class, 'purchase']);
    Route::get('/purchase/{item_id}', [ItemController::class, 'purchase'])->name('purchase.show');
    Route::get('/purchase/address/{item_id}', [ItemController::class, 'address']);
    Route::post('/purchase/address/{item_id}', [ItemController::class, 'address']);
    Route::get('/change', [ItemController::class, 'change']);
    Route::post('/change', [ItemController::class, 'change']);
    Route::post('/buy', [ItemController::class, 'buy']);
    Route::get('/mypage', [ItemController::class, 'mypage']);
    Route::get('/mypage/profile', [UsersAddController::class, 'setProfile'])->name('setProfile');
    Route::post('/upload', [UsersAddController::class, 'image']);
    Route::get('/sell', [ItemController::class, 'sell']);
    Route::post('/sell', [ItemController::class, 'sell']);
    Route::post('/upload_item', [ItemController::class, 'image']);
    Route::post('/setSell', [ItemController::class, 'setSell']);
    });

//

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware(['guest'])
    ->name('register');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function ($id, $hash) {
    $user = User::findOrFail($id);

    if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        abort(403);
    }

    if (!$user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
        event(new Verified($user));
    }

    // 認証済みにしてログイン
    auth()->login($user);

    // プロフィール設定ページなどにリダイレクト
    return redirect()->route('profile.set')->with('verified', true);
})->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', '認証メールを再送しました');
	})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/dashboard', function () {
    return 'Dashboard';
    })->middleware(['auth', 'verified']);

Route::get('/test-mail', function () {
    Mail::raw('MailHog test', function ($message) {
        $message->to('test@example.com')->subject('MailHog Test');
    });
    return 'Mail sent!';
    });

//stripe
Route::get('/checkout', [StripeController::class, 'checkout']);
Route::get('/purchase/success', [PurchaseController::class, 'checkoutSuccess']);
Route::post('/webhook', [PurchaseController::class, 'handleWebhook']);