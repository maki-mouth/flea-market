<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Condition;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SellTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_publish_item_with_valid_data()
    {
        // 1. 準備：ログインユーザー、カテゴリー、状態を作成
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $condition = Condition::factory()->create();

        // ファイルストレージを擬似（Fake）化
        Storage::fake('public');

        // GDライブラリがなくても動く方法で擬似ファイルを生成
        $file = UploadedFile::fake()->create('test_item.jpg', 100, 'image/jpeg');

        // 2. 実行：出品リクエストを送信
        $response = $this->actingAs($user)->post('/sell', [
            'name'         => 'テスト商品',
            'description'  => 'これはテスト商品の説明文です。255文字以内で入力してください。',
            'price'        => 3000,
            'categories'   => [$category->id], // ExhibitionRequestのルール名に合わせる
            'condition_id' => $condition->id,
            'image'        => $file,
        ]);

        // 3. 検証
        // 指定したURLへリダイレクトされるか
        $response->assertRedirect('/');

        // データベースに意図したデータが保存されているか
        $this->assertDatabaseHas('items', [
            'name'         => 'テスト商品',
            'price'        => 3000,
            'user_id'      => $user->id,
            'condition_id' => $condition->id,
        ]);

        // カテゴリーとのリレーション（中間テーブル）が保存されているか（必要に応じて追加）
        $this->assertDatabaseHas('category_item', [
            'category_id' => $category->id,
        ]);
    }
}