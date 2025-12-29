<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Category;


class ItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $item1 = Item::create([
            'name' => '腕時計',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'price' => 15000,
            'brand' => 'Rolax',
            'condition_id' => 1,
            'image' => 'items/Clock.jpg',
            'user_id' => 1,
            'status' => 0,
            'buyer_id' => null,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
            ]);

        $item1->categories()->attach([1, 5]);

        $item2 = Item::create([
            'name' => 'HDD',
            'description' => '高速で信頼性の高いハードディスク',
            'price' => 5000,
            'brand' => '西芝',
            'condition_id' => 2,
            'image' => 'items/HDD.jpg',
            'user_id' => 1,
            'status' => 0,
            'buyer_id' => null,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
            ]);

        $item2->categories()->attach([2]);


        $item3 = Item::create([
            'name' => '玉ねぎ3玉',
            'description' => '新鮮な玉ねぎ3束のセット',
            'price' => 300,
            'brand' => 'なし',
            'condition_id' => 1,
            'image' => 'items/Onion.jpg',
            'user_id' => 1,
            'status' => 0,
            'buyer_id' => null,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
            ]);

        $item3->categories()->attach([10]);

        $item4 = Item::create([
            'name' => '革靴',
            'description' => 'クラシックなデザインの革靴',
            'price' => 4000,
            'brand' => null,
            'condition_id' => 4,
            'image' => 'items/Shoes.jpg',
            'user_id' => 1,
            'status' => 0,
            'buyer_id' => null,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
            ]);

        $item4->categories()->attach([1, 5]);

        $item5 = Item::create([
            'name' => 'ノートPC',
            'description' => '高性能なノートパソコン',
            'price' => 45000,
            'brand' => null,
            'condition_id' => 1,
            'image' => 'items/Laptop.jpg',
            'user_id' => 1,
            'status' => 0,
            'buyer_id' => null,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
            ]);

        $item5->categories()->attach([2]);

        $item6 = Item::create([
            'name' => 'マイク',
            'description' => '高音質のレコーディング用マイク',
            'price' => 8000,
            'brand' => 'なし',
            'condition_id' => 2,
            'image' => 'items/Mic.jpg',
            'user_id' => 1,
            'status' => 0,
            'buyer_id' => null,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
            ]);

        $item6->categories()->attach([2, 13]);

        $item7 = Item::create([
            'name' => 'ショルダーバッグ',
            'description' => 'おしゃれなショルダーバッグ',
            'price' => 3500,
            'brand' => null,
            'condition_id' => 3,
            'image' => 'items/Bag.jpg',
            'user_id' => 1,
            'status' => 0,
            'buyer_id' => null,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
            ]);

        $item7->categories()->attach([1, 4]);

        $item8 = Item::create([
            'name' => 'タンブラー',
            'description' => '使いやすいタンブラー',
            'price' => 500,
            'brand' => 'なし',
            'condition_id' => 4,
            'image' => 'items/Tumbler.jpg',
            'user_id' => 1,
            'status' => 0,
            'buyer_id' => null,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
            ]);

        $item8->categories()->attach([10]);

        $item9 = Item::create([
            'name' => 'コーヒーミル',
            'description' => '手動のコーヒーミル',
            'price' => 2000,
            'brand' => 'Starbacks',
            'condition_id' => 1,
            'image' => 'items/CoffeeGrinder.jpg',
            'user_id' => 1,
            'status' => 0,
            'buyer_id' => null,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
            ]);

        $item9->categories()->attach([3, 10]);

        $item10 = Item::create([
            'name' => 'メイクセット',
            'description' => '便利なメイクアップセット',
            'price' => 2500,
            'brand' => null,
            'condition_id' => 2,
            'image' => 'items/Makeup.jpg',
            'user_id' => 1,
            'status' => 0,
            'buyer_id' => null,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
            ]);

        $item10->categories()->attach([6]);

    }
}
