<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;

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
Route::get('/', [ItemController::class, 'index']);
Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');

// ログイン中のみできるよ～
Route::post('/item/{item}/like', [LikeController::class, 'store'])
    ->name('like.store')
    ->middleware('auth');

    Route::middleware(['auth'])->group(function () {
        Route::get('/mypage', [UserController::class, 'index'])->name('mypage');
        // 表示画面
        Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        // 更新処理
        Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
    });