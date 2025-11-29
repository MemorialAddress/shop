<!DOCTYPE html>
<html lang="ja">

<meta name="viewport" content="width=device-width,initial-scale=1.0">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/header.css') }}" />
    @yield('css')
</head>

<body>
    <div class="top">
        <div class="header">
        <img src="/image/logo.png">
            <div class="header__base">
            <div class="header__search">
                <form action="/" method="GET">
                    @csrf
                    <input type="hidden" name="tab" value="{{ request('tab') }}">
                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="　なにをお探しですか？">
                </form>
            </div>

            @if (Auth::check())
            <div class="header__link">
                <form class="header__link-button" action="/logout" method="post">
                    @csrf
                    <button class="header__link-button-button">ログアウト</button>
                </form>
                <form class="header__link-button" action="/mypage" method="get">
                    @csrf
                    <button class="header__link-button-button">マイページ</button>
                </form>
                <form class="header__link-button2" action="/sell" method="post">
                    @csrf
                    <button class="header__link-button2-button2">出品</button>
                </form>
            </div>

            @else
            <div class="header__link">
                <form class="header__link-button" action="/login" method="get">
                    @csrf
                    <button class="header__link-button-button">ログイン</button>
                </form>
                <form class="header__link-button" action="/mypage" method="get">
                    @csrf
                    <button class="header__link-button-button">マイページ</button>
                </form>
                <form class="header__link-button2" action="/sell" method="post">
                    @csrf
                    <button class="header__link-button2-button2">出品</button>
                </form>
            </div>

            @endif
</div>
        </div>
    </div>

    <main>
        @yield('content')
    </main>
</body>

</html>