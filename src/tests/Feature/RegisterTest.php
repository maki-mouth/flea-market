<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_cannot_register_without_name()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertDatabaseCount('users', 0);
        $response->assertSessionHasErrors(['name']);
    }


    public function test_user_cannot_register_without_email()
    {
        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertDatabaseCount('users', 0);
        $response->assertSessionHasErrors(['email']);
    }

    public function test_user_cannot_register_without_password()
    {
        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $this->assertDatabaseCount('users', 0);
        $response->assertSessionHasErrors(['password']);
        }

        public function test_user_cannot_register_under_7word_password()
    {
        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        $this->assertDatabaseCount('users', 0);
        $response->assertSessionHasErrors(['password']);
    }

    public function test_user_cannot_register_if_password_does_not_match()
    {
        $response = $this->post('/register', [
        'name' => 'テストユーザー',
        'email' => 'fail@example.com',
        'password' => 'password123',
        'password_confirmation' => 'different_password', // あえて違うものを入力
        ]);

        $this->assertDatabaseCount('users', 0);
        $response->assertSessionHasErrors(['password']);
        }

    public function test_user_can_register_with_valid_data()
    {
        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/mypage/profile');
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
        $this->assertAuthenticated();
    }
}