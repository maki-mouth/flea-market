<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class MypageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_get_mypage_information_with_items()
    {
        $user = User::factory()->create(['name' => 'マイページ太郎']);
        \App\Models\Profile::create(['user_id' => $user->id]);

        $seller = User::factory()->create();

        $soldItem = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '私が出品した商品'
        ]);

        $boughtItem = Item::factory()->create([
            'user_id' => $seller->id,
            'buyer_id' => $user->id,
            'name' => '私が購入した商品'
        ]);

        $response = $this->actingAs($user)->get('/mypage');

        $response->assertStatus(200);
        $response->assertSee('マイページ太郎');

        $response->assertSee('私が出品した商品');

        $response = $this->actingAs($user)->get('/mypage?tab=buy');
        $response->assertSee('私が購入した商品');
    }
}
