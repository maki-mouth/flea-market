<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;

class ProfileTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_get_user_profile_information()
    {
        $user = User::factory()->create([
            'name' => 'テスト太郎',
        ]);

        \App\Models\Profile::create([
            'user_id'     => $user->id,
            'postal_code' => '123-4567',
            'address'     => '東京都渋谷区道玄坂',
            'building'    => 'テックビル 5F',
        ]);

        $response = $this->actingAs($user)->get('/mypage/profile');

        $response->assertStatus(200);

        $response->assertSee('テスト太郎');
        $response->assertSee('123-4567');
        $response->assertSee('東京都渋谷区道玄坂');
        $response->assertSee('テックビル 5F');
    }
}
