<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Condition;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommended');

        $items = [];

        if ($tab === 'mylist') {

            if (Auth::check()) {
                $items = Auth::user()->likedItems;
            } else {
                $items = collect();
            }

        } else {

            if (Auth::check()) {
                // ログインしている場合：自分以外の出品商品を取得
                $items = Item::where('user_id', '!=', Auth::id())->get();
            } else {
                // ログインしていない場合：すべての商品を表示
                $items = Item::all();
            }
        }

        return view('index', compact('items', 'tab'));
    }

    public function create()
    {
        $conditions = Condition::all();
        $categories = Category::all();

        return view('sell', compact('conditions', 'categories'));
    }

    public function store(Request $request)
    {
        // 1. バリデーション
        $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'required|string|max:1000',
            'price'        => 'required|integer|min:0',
            'condition_id' => 'required|exists:conditions,id',
            'image'        => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'categories'   => 'required|array', // 複数選択なので配列
        ]);

        // 2. 画像の保存
        // profilesの時と同様、publicディスクのitemsフォルダに保存します
        $path = $request->file('image')->store('items', 'public');

        // 3. 商品の基本情報を保存
        $item = Item::create([
            'user_id'      => Auth::id(),
            'condition_id' => $request->condition_id,
            'name'         => $request->name,
            'brand'        => $request->brand,
            'description'  => $request->description,
            'price'        => $request->price,
            'image'        => $path,
        ]);

        // 4. カテゴリーの紐付け (多対多のリレーション)
        // 中間テーブル（item_category等）にデータを一括挿入します
        if ($request->has('categories')) {
            // category_idの配列（例: [1, 3, 5]）を渡すと同期されます
            $item->categories()->sync($request->categories);
        }

        // 5. 完了後のリダイレクト
        return redirect()->route('items.index');
    }

    public function show(Item $item)
    {
        $item->load('categories');

        return view('item', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }
}
