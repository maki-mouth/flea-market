<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
//use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Item $item)
    {
        // 本来は Auth::user() ですが、開発用に ID 1 のユーザーを強制取得
        $user = \App\Models\User::first(); // 最初のユーザー（ID:1）を連れてくる

        // すでに「いいね」しているか確認し、あれば解除、なければ登録（toggle）
        $user->likedItems()->toggle($item->id);

        return back(); // 元のページに戻る
    }
}
