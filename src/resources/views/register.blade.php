<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>flea-market</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>

<body>
<header class="main-header">
    <a class="header__logo" href="/">
        <img src="{{ asset('img/COACHTECHヘッダーロゴ.png') }}" alt="ヘッダーロゴ">
    </a>
</header>
<main>
    <div class="auth-container">
        <div class="auth-title">会員登録</div>
        <form method="POST" action="{{ route('register') }}" class="auth-form" novalidate>
            @csrf
            <div class="form-group">
                <label>ユーザー名</label>
                <input type="text" name="name" value="{{ old('name') }}">
                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>メールアドレス</label>
                <input type="text" name="email" value="{{ old('email') }}">
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
            <div class="form-group">
                <label>確認用パスワード</label>
                <input type="password" name="password_confirmation">
            </div>
            <div class="form-actions">
                <button type="submit" class="auth-button">登録する</button>
            </div>
            <div class="auth-footer">
                <a href="{{ route('login') }}" class="auth-link">ログインはこちら</a>
            </div>
        </form>
    </div>
</main>
</body>
</html>
