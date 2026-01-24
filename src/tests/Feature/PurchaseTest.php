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

        $response = $this->actingAs($buyer)->get(route('purchase.success', ['item' => $item->id]));

        $response->assertRedirect(route('items.index'));

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'buyer_id' => $buyer->id,
            'status' => Item::STATUS_SOLD,
        ]);

        $indexResponse = $this->get('/');
        $indexResponse->assertSee('Sold');

        $profileResponse = $this->actingAs($buyer)->get('/mypage?tab=buy');
        $profileResponse->assertSee($item->name);
    }

    public function test_user_can_change_payment_method()
    {
        $user = User::factory()->create();
        \App\Models\Profile::create([
            'user_id' => $user->id,
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区...',
        ]);
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->get(route('purchase.show', ['item' => $item->id]));
        $response->assertStatus(200);

        $response = $this->actingAs($user)->post(route('purchase.store', ['item' => $item->id]), [
        'payment_method' => 'konbini',
        ]);

        $response = $this->actingAs($user)->get(route('purchase.show', ['item' => $item->id]));
        $response->assertSee('コンビニ払い');
    }

    public function test_user_can_change_shipping_address_and_it_reflects_on_purchase_page()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $newAddress = [
            'postal_code' => '999-9999',
            'address'     => '東京都千代田区1-1',
            'building'    => '新しいビル101',
        ];

        $this->actingAs($user)->patch(route('address.update', ['item' => $item->id]), $newAddress);

        $this->actingAs($user)->get(route('purchase.success', ['item' => $item->id]));

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'buyer_id' => $user->id,
        ]);

        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'postal_code' => '999-9999',
            'address' => '東京都千代田区1-1',
        ]);
    }
}
