<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>メール認証誘導画面</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/verify.css') }}" />
</head>

<body>
    <header class="header"><img src="/image/logo.png"></header>

    <main>
        <div class="message">
            <div class="message__line">登録して頂いたメールアドレスに認証メールを送付しました。</div>
            <div class="message__line">メール認証を完了してください。</div>
        </div>

        <button class="button__here"  onclick="location.href='http://localhost:8025'">
            認証はこちらから
        </button>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div class="button__retry">
                <button type="submit">認証メールを再送する</button>
            </div>
        </form>

    </main>
