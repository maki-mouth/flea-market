<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileRequest;


class ProfileController extends Controller
{
    /**
     * プロフィール設定画面の表示
     */
    public function edit()
    {
        $user = Auth::user();
        // まだプロフィールがない場合（念のため）作成し、ある場合は取得する
        $profile = $user->profile ?: $user->profile()->create();

        return view('profile', compact('user', 'profile'));
    }

    /**
     * プロフィール情報の更新
     */
    public function update(ProfileRequest $request)
    {

        $user = Auth::user();
        $profile = $user->profile;

        // 2. ユーザー名の更新（usersテーブル）
        $user->update(['name' => $request->name]);

        // 3. プロフィール画像のアップロード処理
        if ($request->hasFile('profile_image')) {
            // 画像を storage/app/public/profiles に保存し、パスを取得
            $path = $request->file('profile_image')->store('profiles', 'public');
            $profile->profile_image = $path;
        }

        // 4. プロフィール情報の更新（profilesテーブル）

        $profile->update([
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        return redirect()->route('items.index');
    }
}



