<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PurchaseController extends Controller
{

    public function show($item_id)
    {
        $item = \App\Models\Item::findOrFail($item_id);
        $user = auth()->user();

        return view('purchase', compact('item', 'user'));
    }

    public function store(PurchaseRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        // すでに売れていないかチェック
        if ($item->status === Item::STATUS_SOLD) {
            return back();
        }

        $paymentMethod = $request->input('payment_method');

        // --- A. カード払いの場合 (Stripe) ---
        if ($paymentMethod === 'card' || $paymentMethod === 'konbini') {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        // 支払い方法のタイプを配列で用意
        $paymentTypes = ($paymentMethod === 'card') ? ['card'] : ['konbini'];

        $session = Session::create([
            'payment_method_types' => $paymentTypes, // ここで切り替え
            'customer_email' => Auth::user()->email,
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => ['name' => $item->name],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            // コンビニ払いの場合は、Stripe側で支払い期限などの追加設定が可能
            'payment_method_options' => [
                'konbini' => [
                    'expires_after_days' => 3, // 3日以内に支払い
                ],
            ],
            'success_url' => route('purchase.success', ['item' => $item_id]),
            'cancel_url' => route('purchase.show', ['item' => $item_id]),
        ]);

        return redirect($session->url);
        }
    }

    public function success(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        // カード決済が完了したのでDBを更新
        $item->update([
            'buyer_id' => Auth::id(),
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
    public function updateAddress(AddressRequest $request, $item_id)
    {

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
        return redirect()->route('purchase.show', ['item' => $item_id]);
    }

}
