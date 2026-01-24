<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Item $item)
    {
        $user = Auth::user();

        $user->likedItems()->toggle($item->id);

        return back();
    }
}
