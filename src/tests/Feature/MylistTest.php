<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class MylistTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_only_favorited_items_are_displayed_on_mylist()
    {
        $user = User::factory()->create();
        $favoriteItem = Item::factory()->create(['name' => 'お気に入りの商品']);
        $otherItem = Item::factory()->create(['name' => '興味のない商品']);

        $user->likedItems()->attach($favoriteItem);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertSee('お気に入りの商品');
        $response->assertDontSee('興味のない商品');
    }

    public function test_sold_items_on_mylist_display_sold_label()
    {
        $user = User::factory()->create();
        $soldItem = Item::factory()->create([
            'name' => '売り切れたお気に入り',
            'status' => '1'
        ]);

        $user->likedItems()->attach($soldItem);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertSee('売り切れたお気に入り');
        $response->assertSee('1');
    }

    public function test_guest_user_sees_nothing_on_mylist()
    {
        $response = $this->get('/?tab=mylist');

        $response->assertDontSee('item-name');
    }
}
