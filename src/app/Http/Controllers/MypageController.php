<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
                // ログインチェック（念のため）
            if (!$user) {
                return redirect()->route('login');
            }

        $profile = $user->profile;

        // 現在のタブを取得（デフォルトは 'sell'：出品した商品）
        $tab = $request->query('tab', 'sell');

        if ($tab === 'buy') {
            // 購入した商品：buyer_id が自分のIDである商品を取得
            $items = Item::where('buyer_id', $user->id)->get();
        } else {
            // 出品した商品：user_id が自分のIDである商品を取得
            $items = Item::where('user_id', $user->id)->get();
        }

        return view('mypage', compact('user', 'profile', 'items', 'tab'));
    }
}
