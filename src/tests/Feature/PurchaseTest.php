<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_purchase_item_and_it_shows_as_sold()
    {
        $seller = User::factory()->create();
        $buyer = User::factory()->create();
        $item = Item::factory()->create(['user_id' => $seller->id, 'buyer_id' => null]);

        // 1. store を叩くのではなく、直接「決済成功URL」にアクセスする
        // これにより、success メソッド内の更新処理が動きます
        $response = $this->actingAs($buyer)->get(route('purchase.success', ['item' => $item->id]));

        // 2. 一覧画面へリダイレクトされることを確認
        $response->assertRedirect(route('items.index'));

        // 3. 検証：DBの buyer_id が更新されているか
        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'buyer_id' => $buyer->id,
            'status' => Item::STATUS_SOLD, // ステータスも確認
        ]);

        // 4. 検証：商品一覧画面で「Sold」と表示されるか
        $indexResponse = $this->get('/');
        $indexResponse->assertSee('Sold');

        // 5. 検証：プロフィールの購入した商品一覧に表示されるか
        // type=buy で正しく絞り込まれている前提です
        $profileResponse = $this->actingAs($buyer)->get('/mypage?tab=buy');
        $profileResponse->assertSee($item->name);
    }
}
