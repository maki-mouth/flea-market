<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_authenticated_user_can_send_comment()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post("/items/{$item->id}/comment", [
            'comment' => 'これはテストコメントです。'
        ]);

        $this->assertDatabaseHas('comments', [
            'item_id' => $item->id,
            'user_id' => $user->id,
            'comment' => 'これはテストコメントです。'
        ]);
    }

    public function test_guest_user_cannot_send_comment()
    {
        $item = Item::factory()->create();

        $response = $this->post("/items/{$item->id}/comment", [
            'comment' => '未ログインのコメント'
        ]);

        $response->assertRedirect('/login');
    }

    public function test_comment_is_required()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post("/items/{$item->id}/comment", [
            'comment' => ''
        ]);

        $response->assertSessionHasErrors(['comment']);
    }

    public function test_comment_max_length_validation()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $longComment = str_repeat('あ', 256);
        $response = $this->actingAs($user)->post("/items/{$item->id}/comment", [
            'comment' => $longComment
        ]);

        $response->assertSessionHasErrors(['comment']);
    }
}
