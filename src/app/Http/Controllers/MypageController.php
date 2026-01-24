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

            if (!$user) {
                return redirect()->route('login');
            }

        $profile = $user->profile;

        $tab = $request->query('tab', 'sell');

        if ($tab === 'buy') {
            $items = Item::where('buyer_id', $user->id)->get();
        } else {
            $items = Item::where('user_id', $user->id)->get();
        }

        return view('mypage', compact('user', 'profile', 'items', 'tab'));
    }
}
