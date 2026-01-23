<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Category;
use App\Models\Condition;

class ItemTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_item_detail_page_displays_all_required_information()
    {
        // 1. 関連データ（カテゴリー、商品の状態、出品者）を準備
        $category = Category::factory()->create(['name' => 'ファッション']);
        $condition = Condition::factory()->create(['name' => '目立った傷や汚れなし']);
        $user = User::factory()->create();

        // 2. 詳細表示用の商品を作成
        $item = Item::factory()->create([
            'user_id' => $user->id,
            'condition_id' => $condition->id,
            'name' => 'こだわりのTシャツ',
            'brand' => 'ブランド名',
            'price' => 2500,
            'description' => 'これはテスト用の説明文です。',
            'image' => 'items/sample.jpg',
        ]);

        // カテゴリーを商品に紐付け
        $item->categories()->attach($category->id);

        // 3. 詳細ページにアクセス
        $response = $this->get("/items/{$item->id}");

        // 4. 各情報が画面に表示されているか確認
        $response->assertStatus(200);
        $response->assertSee('こだわりのTシャツ');
        $response->assertSee('ブランド名');
        $response->assertSee('2,500');
        $response->assertSee('これはテスト用の説明文です。');
        $response->assertSee('ファッション'); // カテゴリー名
        $response->assertSee('目立った傷や汚れなし');
        $response->assertSee('items/sample.jpg'); // 画像パス
    }

    public function test_item_detail_page_displays_multiple_categories()
    {
        // 1. カテゴリーを2つ作成
        $category1 = Category::factory()->create(['name' => 'ファッション']);
        $category2 = Category::factory()->create(['name' => 'メンズ']);

        $item = Item::factory()->create();

        // 2. 両方のカテゴリーを商品に紐付ける
        $item->categories()->attach([$category1->id, $category2->id]);

        // 3. 詳細ページにアクセス
        $response = $this->get("/items/{$item->id}");

        // 4. 両方の名前が画面に存在することを確認
        $response->assertStatus(200);
        $response->assertSee('ファッション');
        $response->assertSee('メンズ');
    }
}
