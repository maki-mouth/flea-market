@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="auth-container">
    <div class="auth-title">ログイン</div>
    <form method="POST" action="{{ route('login') }}" class="auth-form" novalidate>
        @csrf
        <div class="form-group">
            <label>メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}">
            @error('email')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label>パスワード</label>
            <input type="password" name="password">
            @error('password')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="auth-button">ログインする</button>
        </div>
        <div class="auth-footer">
            <a href="{{ route('register') }}" class="auth-link">会員登録はこちら</a>
        </div>
    </form>
</div>
@endsection