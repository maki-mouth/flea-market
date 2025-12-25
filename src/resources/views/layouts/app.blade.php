<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>flea-market</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('css')
</head>

<body>
<header class="main-header">
    {{-- ロゴリンク --}}
    <a class="header__logo" href="/">
        <img src="{{ asset('img/COACHTECHヘッダーロゴ.png') }}" alt="ヘッダーロゴ">
    </a>
    {{-- 検索バー --}}
    <div class="search-area">
        <input type="search" placeholder="なにをお探しですか?" class="search-input">
    </div>
    {{-- アクションボタン --}}
    <div class="actions">
        <a href="" class="action-link">ログイン</a>
        <a href="" class="action-link">マイページ</a>
        <a href="" class="btn-primary">出品</a>
    </div>
</header>

<main>
    @yield('content')
</main>
</body>

</html>
