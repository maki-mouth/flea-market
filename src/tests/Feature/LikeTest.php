<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class LikeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_like_an_item()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // 1. ログインしていいねを実行（POSTリクエスト）
        $response = $this->actingAs($user)->post("/item/{$item->id}/like");

        // 2. DBにお気に入りデータが登録されているか確認
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    /** @test */
    public function test_like_icon_changes_color_when_liked()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // 1. 最初は「デフォルト（白抜き）」のハートがあることを確認
        $response = $this->actingAs($user)->get("/items/{$item->id}");
        $response->assertSee('img/ハートロゴ_デフォルト.png'); 

        // 2. いいねを実行
        $user->likedItems()->attach($item);

        $user->refresh();

        // 3. 再度アクセスして、アイコンが「アクティブ（色付き）」に変わっているか確認
        $response = $this->actingAs($user)->get("/items/{$item->id}");
        $response->assertSee('img/ハートロゴ_ピンク.png'); // あなたが設定した画像名に合わせてください
        $response->assertDontSee('img/ハートロゴ_デフォルト.png');
    }

    /** @test */
    public function test_user_can_unlike_an_item()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // 1. 先にお気に入り登録しておく
        $user->likedItems()->attach($item);

        // 2. 再度POSTリクエスト（トグル機能なら同じURL、あるいは削除用URL）
        $response = $this->actingAs($user)->post("/item/{$item->id}/like");

        // 3. DBからデータが消えていることを確認
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }
}
