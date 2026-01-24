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

        if ($item->status === Item::STATUS_SOLD) {
            return back();
        }

        $paymentMethod = $request->input('payment_method');

        if ($paymentMethod === 'card' || $paymentMethod === 'konbini') {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            $paymentTypes = ($paymentMethod === 'card') ? ['card'] : ['konbini'];

            $session = Session::create([
                'payment_method_types' => $paymentTypes,
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
                'payment_method_options' => [
                    'konbini' => [
                        'expires_after_days' => 3,
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

        $item->update([
            'buyer_id' => Auth::id(),
            'status' => Item::STATUS_SOLD,
            'sold_at' => now(),
        ]);

        return redirect()->route('items.index');
    }

    public function edit($item_id)
    {
        $user = Auth::user();
        $user->load('profile');

        return view('address', ['user' => $user,'item_id' => $item_id]);
    }

    public function updateAddress(AddressRequest $request, $item_id)
    {
        $user = Auth::user();
        Profile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'postal_code' => $request->postal_code,
                'address'     => $request->address,
                'building'    => $request->building,
            ]
        );

        return redirect()->route('purchase.show', ['item' => $item_id]);
    }
}
