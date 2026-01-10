@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="profile-container">
    <h2 class="profile-title">プロフィール設定</h2>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="profile-form">
        @csrf
        
        {{-- プロフィール画像セクション --}}
        <div class="avatar-section">
            <div class="avatar-preview">
                @if($profile->profile_image)
                    <img src="{{ asset('storage/' . $profile->profile_image) }}" id="profile-img-preview" alt="ユーザー画像">
                @else
                    <img src="" id="profile-img-preview" alt="ユーザー画像" style="display: none;">
                    <div id="avatar-placeholder" class="avatar-placeholder"></div>
                @endif
            </div>
            <label class="avatar-label">
                画像を選択する
                <input type="file" name="profile_image" id="avatar-input" accept="profile_image/*" class="avatar-input">
                @error('profile_image') <a class="error">{{ $message }}</a> @enderror
            </label>
        </div>

        {{-- 入力項目 --}}
        <div class="form-group">
            <label for="name">ユーザー名</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}">
            @error('name') <a class="error">{{ $message }}</a> @enderror
        </div>

        <div class="form-group">
            <label for="postal_code">郵便番号</label>
            <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $profile->postal_code) }}">
            @error('postal_code') <a class="error">{{ $message }}</a> @enderror
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" name="address" id="address" value="{{ old('address', $profile->address) }}">
            @error('address') <a class="error">{{ $message }}</a> @enderror
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" name="building" id="building" value="{{ old('building', $profile->building) }}">
            @error('building') <a class="error">{{ $message }}</a> @enderror
        </div>

        <button type="submit" class="btn-submit">更新する</button>
    </form>
</div>
<script>
    document.getElementById('avatar-input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('profile-img-preview');
        const placeholder = document.getElementById('avatar-placeholder');

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block'; // 画像を表示
                if (placeholder) {
                    placeholder.style.display = 'none'; // グレーの丸を隠す
                }
            }

            reader.readAsDataURL(file); // ファイルを読み込む
        }
    });
</script>
@endsection