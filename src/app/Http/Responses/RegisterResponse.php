<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        // 会員登録後だけ、プロフィール設定画面にリダイレクトさせる
        return redirect('/mypage/profile');
    }
}