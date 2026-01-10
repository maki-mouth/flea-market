<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Profile;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
public function create(array $input)
    {
        // 1. RegisterRequestのインスタンスを生成
        $request = new RegisterRequest();

        // 2. RegisterRequestのルールとメッセージを使用してバリデーションを実行
        Validator::make(
            $input,
            $request->rules(),
            $request->messages()
        )->validate();

        // 3. ユーザー作成とプロフィールの紐付けをトランザクション内で行う
        return DB::transaction(function () use ($input) {
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);

            // 空のプロフィールを作成して紐付け
            $user->profile()->create();

            return $user;
        });
    }
}