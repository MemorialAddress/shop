<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UsersAddController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;

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


Route::middleware('auth')->group(function () {
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

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware(['guest'])
    ->name('register');
