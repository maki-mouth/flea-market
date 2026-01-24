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
        $category = Category::factory()->create(['name' => 'ファッション']);
        $condition = Condition::factory()->create(['name' => '目立った傷や汚れなし']);
        $user = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $user->id,
            'condition_id' => $condition->id,
            'name' => 'こだわりのTシャツ',
            'brand' => 'ブランド名',
            'price' => 2500,
            'description' => 'これはテスト用の説明文です。',
            'image' => 'items/sample.jpg',
        ]);

        $item->categories()->attach($category->id);

        $response = $this->get("/items/{$item->id}");

        $response->assertStatus(200);
        $response->assertSee('こだわりのTシャツ');
        $response->assertSee('ブランド名');
        $response->assertSee('2,500');
        $response->assertSee('これはテスト用の説明文です。');
        $response->assertSee('ファッション');
        $response->assertSee('目立った傷や汚れなし');
        $response->assertSee('items/sample.jpg');
    }

    public function test_item_detail_page_displays_multiple_categories()
    {
        $category1 = Category::factory()->create(['name' => 'ファッション']);
        $category2 = Category::factory()->create(['name' => 'メンズ']);

        $item = Item::factory()->create();

        $item->categories()->attach([$category1->id, $category2->id]);

        $response = $this->get("/items/{$item->id}");

        $response->assertStatus(200);
        $response->assertSee('ファッション');
        $response->assertSee('メンズ');
    }
}
