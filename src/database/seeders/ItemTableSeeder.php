<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            [
            'name' => '腕時計',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'price' => 15000,
            'brand' => 'Rolax',
            'category_id' => 12,
            'condition_id' => 1,
            'image' => 'items/Clock.jpg',
            'user_id' => 1,
            'status' => 0,
            'buyer_id' => null,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
            ],

            [
            'name' => 'HDD',
            'description' => '高速で信頼性の高いハードディスク',
            'price' => 5000,
            'brand' => '西芝',
            'category_id' => 2,
            'condition_id' => 2,
            'image' => 'items/HDD.jpg',
            'user_id' => 1,
            'status' => 0,
            'buyer_id' => null,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
            ],

            [
            'name' => '玉ねぎ3玉',
            'description' => '新鮮な玉ねぎ3束のセット',
            'price' => 300,
            'brand' => 'なし',
            'category_id' => 10,
            'condition_id' => 1,
            'image' => 'items/Onion.jpg',
            'user_id' => 1,
            'status' => 0,
            'buyer_id' => null,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
            ],

            [
            'name' => '革靴',
            'description' => 'クラシックなデザインの革靴',
            'price' => 4000,
            'brand' => null,
            'category_id' => 5,
            'condition_id' => 4,
            'image' => 'items/Shoes.jpg',
            'user_id' => 1,
            'status' => 0,
            'buyer_id' => null,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
            ],

            [
            'name' => 'ノートPC',
            'description' => '高性能なノートパソコン',
            'price' => 45000,
            'brand' => null,
            'category_id' => 2,
            'condition_id' => 1,
            'image' => 'items/Laptop.jpg',
            'user_id' => 1,
            'status' => 0,
            'buyer_id' => null,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
            ],

            [
            'name' => 'マイク',
            'description' => '高音質のレコーディング用マイク',
            'price' => 8000,
            'brand' => 'なし',
            'category_id' => 2,
            'condition_id' => 2,
            'image' => 'items/Mic.jpg',
            'user_id' => 1,
            'status' => 0,
            'buyer_id' => null,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
            ],

            [
            'name' => 'ショルダーバッグ',
            'description' => 'おしゃれなショルダーバッグ',
            'price' => 3500,
            'brand' => null,
            'category_id' => 4,
            'condition_id' => 3,
            'image' => 'items/Bag.jpg',
            'user_id' => 1,
            'status' => 0,
            'buyer_id' => null,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
            ],

            [
            'name' => 'タンブラー',
            'description' => '使いやすいタンブラー',
            'price' => 500,
            'brand' => 'なし',
            'category_id' => 10,
            'condition_id' => 4,
            'image' => 'items/Tumbler.jpg',
            'user_id' => 1,
            'status' => 0,
            'buyer_id' => null,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
            ],

            [
            'name' => 'コーヒーミル',
            'description' => '手動のコーヒーミル',
            'price' => 2000,
            'brand' => 'Starbacks',
            'category_id' => 10,
            'condition_id' => 1,
            'image' => 'items/CoffeeGrinder.jpg',
            'user_id' => 1,
            'status' => 0,
            'buyer_id' => null,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
            ],

            [
            'name' => 'メイクセット',
            'description' => '便利なメイクアップセット',
            'price' => 2500,
            'brand' => null,
            'category_id' => 6,
            'condition_id' => 2,
            'image' => 'items/Makeup.jpg',
            'user_id' => 1,
            'status' => 0,
            'buyer_id' => null,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
            ]
        ]);
    }
}
