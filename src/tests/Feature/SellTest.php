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
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $condition = Condition::factory()->create();

        Storage::fake('public');

        $file = UploadedFile::fake()->create('test_item.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($user)->post('/sell', [
            'name'         => 'テスト商品',
            'description'  => 'これはテスト商品の説明文です。255文字以内で入力してください。',
            'price'        => 3000,
            'categories'   => [$category->id],
            'condition_id' => $condition->id,
            'image'        => $file,
        ]);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('items', [
            'name'         => 'テスト商品',
            'price'        => 3000,
            'user_id'      => $user->id,
            'condition_id' => $condition->id,
        ]);

        $this->assertDatabaseHas('category_item', [
            'category_id' => $category->id,
        ]);
    }
}