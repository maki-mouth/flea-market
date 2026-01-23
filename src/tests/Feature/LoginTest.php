<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_login_with_correct_credentials()
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/'); // あなたのアプリのトップページURLに合わせてください

        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_incorrect_password()
    {
        $user = User::factory()->create([
            'password' => bcrypt('correct-password'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_user_cannot_login_without_email()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password123',
        ]);

        $this->assertGuest();

        $response->assertSessionHasErrors(['email']);
    }

    public function test_user_cannot_login_without_password()
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => '',
        ]);

        $this->assertGuest();

        $response->assertSessionHasErrors(['password']);
    }

    public function test_user_cannot_login_with_unregistered_email()
    {
        $response = $this->post('/login', [
            'email' => 'not-found@example.com',
            'password' => 'password123',
        ]);

        $this->assertGuest();

        $response->assertSessionHasErrors(['email']);
    }
}