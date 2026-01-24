<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Condition;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ExhibitionRequest;


class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommended');
        $keyword = $request->query('keyword');

        $query = Item::query();

        if (!empty($keyword)) {
            $query->where('name', 'LIKE', "%{$keyword}%");
        }

        if ($tab === 'mylist') {
            $items = Auth::check()
                ? Auth::user()->likedItems()->where(function($q) use ($keyword) {
                    if ($keyword) $q->where('name', 'LIKE', "%{$keyword}%");
                })->get()
                : collect();
        } else {
        if (Auth::check()) {
            $query->where('user_id', '!=', Auth::id());
        }

        $items = $query->get();
        }

        return view('index', compact('items', 'tab'));
    }

    public function create()
    {
        $conditions = Condition::all();
        $categories = Category::all();

        return view('sell', compact('conditions', 'categories'));
    }

    public function store(ExhibitionRequest $request)
    {
        $path = $request->file('image')->store('items', 'public');

        $item = Item::create([
            'user_id'      => Auth::id(),
            'condition_id' => $request->condition_id,
            'name'         => $request->name,
            'brand'        => $request->brand,
            'description'  => $request->description,
            'price'        => $request->price,
            'image'        => $path,
        ]);

        if ($request->has('categories')) {
            $item->categories()->sync($request->categories);

        }

        return redirect()->route('items.index');
    }

    public function show(Item $item)
    {
        $item->load('categories');

        return view('item', compact('item'));
    }
}