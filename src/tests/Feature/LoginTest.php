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
        // 1. テスト用のユーザーをあらかじめ1人作成しておく
        $user = User::factory()->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);

        // 2. ログイン画面にアクセスし、データを送信
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        // 3. ログイン後のページへリダイレクトされるか確認
        $response->assertRedirect('/'); // あなたのアプリのトップページURLに合わせてください

        // 4. 指定したユーザーとしてログイン状態になっているか確認
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_incorrect_password()
    {
        $user = User::factory()->create([
            'password' => bcrypt('correct-password'),
        ]);

        // あえて違うパスワードで送信
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        // ログインに失敗し、ログイン状態になっていないことを確認
        $this->assertGuest();
    }

    public function test_user_cannot_login_without_email()
    {
        // 1. メールアドレスを空にしてログインを試みる
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password123',
        ]);

        // 2. ログインに失敗し、ゲスト状態であることを確認
        $this->assertGuest();

        // 3. セッションにemailのエラーが含まれているか確認
        $response->assertSessionHasErrors(['email']);
    }

    public function test_user_cannot_login_without_password()
    {
        // 1. メールアドレスを空にしてログインを試みる
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => '',
        ]);

        // 2. ログインに失敗し、ゲスト状態であることを確認
        $this->assertGuest();

        // 3. セッションにpasswordのエラーが含まれているか確認
        $response->assertSessionHasErrors(['password']);
    }
}