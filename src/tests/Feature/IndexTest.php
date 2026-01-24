<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class IndexTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_all_items_are_displayed_on_index_page()
    {
        $user = User::factory()->create();

        $items = Item::factory()->count(3)->create([
            'user_id' => $user->id
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);

        foreach ($items as $item) {
            $response->assertSee($item->name);
        }

        $response->assertViewHas('items', function ($viewItems) {
            return $viewItems->count() === 3;
        });
    }

    public function test_sold_items_display_soldout_label()
    {
        Item::factory()->create([
            'name' => '売れた商品',
            'status' => '1',
        ]);

        Item::factory()->create([
            'name' => '販売中の商品',
            'status' => '0',
        ]);

        $response = $this->get('/');

        $response->assertSee('Sold');
        $response->assertSee('売れた商品');
        $response->assertSee('販売中の商品');
    }

    public function test_my_items_are_not_displayed_on_index_page()
    {
        $me = User::factory()->create();
        $otherUser = User::factory()->create();

        $myItem = Item::factory()->create([
            'name' => '私の出品物',
            'user_id' => $me->id,
        ]);

        $othersItem = Item::factory()->create([
            'name' => '他人の出品物',
            'user_id' => $otherUser->id,
        ]);

        $response = $this->actingAs($me)->get('/');

        $response->assertSee('他人の出品物');
        $response->assertDontSee('私の出品物');
    }

    public function test_item_search_by_name_partial_match()
    {
        Item::factory()->create(['name' => '限定スニーカー']);
        Item::factory()->create(['name' => '中古の革靴']);
        Item::factory()->create(['name' => '青いシャツ']);

        $response = $this->get('/?keyword=スニーカー');

        $response->assertStatus(200);
        $response->assertSee('限定スニーカー');
        $response->assertDontSee('中古の革靴');
        $response->assertDontSee('青いシャツ');
    }

    public function test_search_query_is_maintained_when_switching_to_mylist()
    {
        $user = User::factory()->create();

        $favoriteItem = Item::factory()->create(['name' => 'お気に入りのスニーカー']);
        $otherItem = Item::factory()->create(['name' => '普通のスニーカー']);

        $user->likedItems()->attach($favoriteItem);
        $response = $this->actingAs($user)->get('/?keyword=スニーカー&tab=mylist');

        $response->assertSee('お気に入りのスニーカー');
        $response->assertDontSee('普通のスニーカー');

        $response->assertSee('value="スニーカー"', false);
    }
}
