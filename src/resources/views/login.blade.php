@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<div class="auth-container">
    <h2 class="auth-title">ログイン</h2>
    
    <form method="POST" action="" class="auth-form">
        @csrf
        
        <div class="form-group">
            <label>メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>パスワード</label>
            <input type="password" name="password" required>
            @error('password') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="auth-button">ログインする</button>
        </div>
        
        <div class="auth-footer">
            <a href="" class="auth-link">会員登録はこちら</a>
        </div>
    </form>
</div>
@endsection