<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>flea-market</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
</head>

<body>
<header class="main-header">
    <a class="header__logo" href="/">
        <img src="{{ asset('img/COACHTECHヘッダーロゴ.png') }}" alt="ヘッダーロゴ">
    </a>
</header>
<main>
    <div class="message-box">
        <p>登録していただいたメールアドレスに認証メールを送付しました。</p>
        <p>メール認証を完了してください。</p>
    </div>
    <a href="https://mailtrap.io/inboxes" target="_blank" class="instruction">認証はこちらから</a>
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="resend-button">認証メールを再送する</button>
    </form>
</main>
</body>
</html>