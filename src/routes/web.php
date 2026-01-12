<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\MypageController;

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
Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');

// ログイン中のみできるよ～
Route::middleware(['auth'])->group(function () {
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage');
    // 表示画面
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // 更新処理
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
    // コメント投稿
    Route::post('/items/{item}/comment', [CommentController::class, 'store'])->name('comment.store');
    Route::post('/item/{item}/like', [LikeController::class, 'store'])->name('like.store');
    Route::get('/sell', [ItemController::class, 'create'])->name('sell.create');
    Route::post('/sell', [ItemController::class, 'store'])->name('sell.store');
    Route::get('/purchase/{item}', [PurchaseController::class, 'show'])->name('purchase.show');
    Route::post('/purchase/{item}', [PurchaseController::class, 'store'])->name('purchase.store');
    // 住所表示
    Route::get('/purchase/address/{item}', [PurchaseController::class, 'edit'])->name('address.edit');
    // 住所更新
    Route::patch('/purchase/address/{item}', [PurchaseController::class, 'updateAddress'])->name('address.update');
    Route::get('/purchase/success/{item}', [PurchaseController::class, 'success'])->name('purchase.success');
});