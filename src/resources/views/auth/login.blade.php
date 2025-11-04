<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ログイン画面</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
</head>

<body>
  <header class="header"><img src="image/logo.png"></header>

  <main>
    <form action="/login" method="post">
    @csrf
    <div class="form">
      <div class="form__title">ログイン</div>
      <div class="form__contents">

        <div class="form__contents-title">メールアドレス</div>
        <div class="form__contents-input">
          <input type="text" name="email" value="{{ old('email') }}">
          <div class="form__contents-error">
          @error('email')
            {{ $message }}
          @enderror
          </div>
        </div>

        <div class="form__contents-title">パスワード</div>
        <div class="form__contents-input">
          <input type="password" name="password">
          <div class="form__contents-error">
          @error('password')
            {{ $message }}
          @enderror
          </div>
        </div>

      </div>
    </div>

    <div class="button">
      <button type="submit">ログインする</button>
    </div>
    </form>
    <div class="register">
      <a href="/register">会員登録はこちら</a>
    </div>
  </main>
</body>
</html>
