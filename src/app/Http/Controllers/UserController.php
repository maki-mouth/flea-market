<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // ログインチェック（念のため）
            if (!$user) {
                return redirect()->route('login');
            }

        $profile = $user->profile;

        // 自分が商品を出品している場合、その一覧を取得
        $items = \App\Models\Item::where('user_id', $user->id)->get();

        return view('mypage', compact('user', 'profile', 'items'));
    }
}
