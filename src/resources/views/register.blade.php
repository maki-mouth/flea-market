@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">

<div class="auth-container">
    <h2 class="auth-title">会員登録</h2>

    <form method="POST" action="" class="auth-form">
        @csrf

        <div class="form-group">
            <label>ユーザー名</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus>
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>パスワード</label>
            <input type="password" name="password" required>
            @error('password') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>確認用パスワード</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="auth-button">登録する</button>
        </div>

        <div class="auth-footer">
            <a href="" class="auth-link">ログインはこちら</a>
        </div>
    </form>
</div>
@endsection