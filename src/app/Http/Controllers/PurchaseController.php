<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{

    public function show($item_id)
    {
        $item = \App\Models\Item::findOrFail($item_id);
        $user = auth()->user();

        return view('purchase', compact('item', 'user'));
    }

    public function store(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        // すでに売れていないかチェック
        if ($item->status === Item::STATUS_SOLD) {
            return back();
        }

        // 購入処理：buyer_id に自分のIDを入れて保存
        $item->update([
            'buyer_id' => Auth::id(),
            'payment_method' => $request->input('payment_method'),
            'status' => Item::STATUS_SOLD,
            'sold_at' => now(),
        ]);

        return redirect()->route('items.index');
    }

        // 住所変更画面の表示
    public function edit($item_id)
    {
        $user = Auth::user();
        // プロフィール情報がない場合に備えて取得（既にある前提ですが念のため）
        $user->load('profile');

        return view('address', [
            'user' => $user,
            'item_id' => $item_id // 戻る先の特定に必要
        ]);
    }

    // 住所の更新処理
    public function updateAddress(Request $request, $item_id)
    {
        // 1. バリデーション
        $request->validate([
            'postal_code' => 'required|max:8',
            'address'     => 'required|max:255',
            'building'    => 'nullable|max:255',
        ]);

        $user = Auth::user();

        // 2. プロフィール情報の更新
        // updateOrCreate を使うと、万が一プロフィール未作成でも作成されます
        Profile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'postal_code' => $request->postal_code,
                'address'     => $request->address,
                'building'    => $request->building,
            ]
        );

        // 3. 購入画面へリダイレクト（商品IDを渡す）
        return redirect()->route('purchase.show', ['item' => $item_id])
                            ->with('message', '配送先を変更しました');
    }
}
