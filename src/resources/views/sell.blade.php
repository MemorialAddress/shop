@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/sell.css') }}" />
@endsection

@section('content')
  <title>商品の出品</title>

  <main>
    <div class="form">
      <div class="form__title">商品の出品</div>

      <div class="form__contents1">
        <div class="form__contents1-image">
          <div class="form__contents1-imageTitle">商品画像</div>
          <div class="form__contents1-imageArea">
            <form action="/upload_item" method="POST" enctype="multipart/form-data" class="form__contents-upload">
              @csrf
                <input type="file" name="image" id="fileInput" style="display:none">
                <button type="submit" id="customButton" class="form__contents1-button">画像を選択する</button>
            </form>
          </div>
          @error('image')
            {{ $message }}
          @enderror
        </div>
      </div>

      <div class="form__contents2">
        <div class="form__contents2-Title">商品の詳細</div><br><hr>
        <div class="form__contents2-Category">
          <div class="form__contents2-CategoryTitle">
            カテゴリー
          </div>
          <div class="form__contents2-CategoryList">
            <span class="form__contents2-CategoryName">ファッション</span>
            <span class="form__contents2-CategoryName">家電</span>
            <span class="form__contents2-CategoryName">インテリア</span>
            <span class="form__contents2-CategoryName">レディース</span>
            <span class="form__contents2-CategoryName">メンズ</span>
            <span class="form__contents2-CategoryName">コスメ</span>
            <span class="form__contents2-CategoryName">本</span>
            <span class="form__contents2-CategoryName">ゲーム</span>
            <span class="form__contents2-CategoryName">スポーツ</span>
            <span class="form__contents2-CategoryName">キッチン</span>
            <span class="form__contents2-CategoryName">ハンドメイド</span>
            <span class="form__contents2-CategoryName">アクセサリー</span>
            <span class="form__contents2-CategoryName">おもちゃ</span>
            <span class="form__contents2-CategoryName">ベビー・キッズ</span>
          </div>
        </div>
      </div>

      <div class="form__contents3">
        <div class="form__contents3-CategoryTitle">
          商品の状態
        </div>
        <select name="condition" class="form__contents3-Condition">
          <option value="">選択してください</option>
          <option>良好</option>
          <option>目立った傷や汚れなし</option>
          <option>やや傷や汚れあり</option>
          <option>状態が悪い</option>
        </select>
      </div>

      <div class="form__contents4">
        <div class="form__contents4-Title">商品名と説明</div><hr>
        <div class="form__contents4-SubTitle">商品名</div>
        <input type="text" name="item_name" class="form__contents4-Input">
        <div class="form__contents4-SubTitle">ブランド名</div>
        <input type="text" name="item_name" class="form__contents4-Input">
        <div class="form__contents4-SubTitle">商品の説明</div>
        <input type="text" name="item_name" class="form__contents4-Input2">
        <div class="form__contents4-SubTitle">販売価格</div>
        <div class="form__contents4-price">
          <span class="price-symbol">¥</span>
          <input type="text" name="price" class="form__contents4-InputPrice">
        </div>
      </div>

      <button type="submit" class="button">出品する</button>


<script>
  const fileInput = document.getElementById('fileInput');
  const customButton = document.getElementById('customButton');
  const form = fileInput.closest('form'); // form を取得

  customButton.addEventListener('click', (e) => {
      e.preventDefault();
      fileInput.click();
  });
  fileInput.addEventListener('change', () => {
      if (fileInput.files.length > 0) {
          fileInput.closest('form').submit();
      }
  });
</script>
@endsection
