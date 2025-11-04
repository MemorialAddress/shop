<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>会員登録画面</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/register.css') }}" />
</head>

<body>
  <header class="header"><img src="image/logo.png"></header>

  <main>
    <form action="/register" method="post">
    @csrf
    <div class="form">
      <div class="form__title">会員登録</div>
      <div class="form__contents">

        <div class="form__contents-title">ユーザー名</div>
        <div class="form__contents-input">
          <input type="text" name="name" value="{{ old('name') }}">
          <div class="form__contents-error">
          @error('name')
            {{ $message }}
          @enderror
          </div>
        </div>

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

        <div class="form__contents-title">確認用パスワード</div>
        <div class="form__contents-input">
          <input type="password" name="password_confirmation"></div>
          <div class="form__contents-error">
          @error('password_confirmation')
            {{ $message }}
          @enderror
          </div>
        </div>
    </div>
    <div class="button">
      <button type="submit">登録する</button>
    </div>
    </form>
    <div class="login">
      <a href="/login">ログインはこちら</a>
    </div>
  </main>
</body>
</html>
