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
        $keyword = $request->query('keyword'); // 検索ワードを取得

        // クエリの基本形を作成
        $query = Item::query();

        // 部分一致検索のロジックを追加
        if (!empty($keyword)) {
            $query->where('name', 'LIKE', "%{$keyword}%");
        }

        if ($tab === 'mylist') {
            // マイリストタブ: 自分がいいねした商品
            $items = Auth::check()
                ? Auth::user()->likedItems()->where(function($q) use ($keyword) {
                    if ($keyword) $q->where('name', 'LIKE', "%{$keyword}%");
                })->get()
                : collect();
        } else {
            // おすすめタブ: 自分以外の出品商品
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
        // 1. バリデーションはExhibitionRequestで実施済み
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

}