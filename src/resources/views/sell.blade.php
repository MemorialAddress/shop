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

          @if(session('uploaded_file'))
              <div class="form__contents1-imageArea2">
                <div class="form__contents1-imageArea2sub">
                  <img src="/storage/image/item/{{ session('uploaded_file') }}">
                  <form action="/upload_item" method="POST" enctype="multipart/form-data" class="form__contents-upload2">
                    @csrf
                    <input type="file" name="image" id="fileInput" style="display:none">
                    <button type="submit" id="customButton" class="form__contents1-button">画像を選択する</button>
                  </form>
                </div>
              </div>
            @else
              <div class="form__contents1-imageArea">
                <form action="/upload_item" method="POST" enctype="multipart/form-data" class="form__contents-upload">
                  @csrf
                  <input type="file" name="image" id="fileInput" style="display:none">
                  <button type="submit" id="customButton" class="form__contents1-button">画像を選択する</button>
                </form>
              </div>
            @endif

          <div class="form__contents-error">
          @error('image')
            {{ $message }}
          @enderror
          </div>
        </div>
      </div>

      <form action="/setSell" method="post">
      @csrf
      <div class="form__contents2">
        <div class="form__contents2-Title">商品の詳細</div><br><hr>
        <div class="form__contents2-Category">
          <div class="form__contents2-CategoryTitle">
            カテゴリー
          </div>
          <div class="form__contents2-CategoryList">
            @php
              $categoryNames = [
                1 => 'ファッション',
                2 => '家電',
                3 => 'インテリア',
                4 => 'レディース',
                5 => 'メンズ',
                6 => 'コスメ',
                7 => '本',
                8 => 'ゲーム',
                9 => 'スポーツ',
                10 => 'キッチン',
                11 => 'ハンドメイド',
                12 => 'アクセサリー',
                13 => 'おもちゃ',
                14 => 'ベビー・キッズ',
              ];
            @endphp

            @foreach ($categoryNames as $id => $name)
              <button type="button" class="category-btn form__contents2-CategoryOFF" data-category="{{ $id }}">{{ $name }}</button>
              <input type="hidden" name="category{{ $id }}" value="0">
            @endforeach
          </div>
          <div class="form__contents-error">
          @error('category')
            {{ $message }}
          @enderror
          </div>
        </div>
      </div>

      <div class="form__contents3">
        <div class="form__contents3-CategoryTitle">
          商品の状態
        </div>
        <select name="condition" class="form__contents3-Condition">
          <option value="">選択してください</option>
          <option value="良好">良好</option>
          <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
          <option value="やや傷や汚れあり">やや傷や汚れあり</option>
          <option value="状態が悪い">状態が悪い</option>
        </select>
        <div class="form__contents-error">
        @error('condition')
          {{ $message }}
        @enderror
        </div>
      </div>

      <div class="form__contents4">
        <div class="form__contents4-Title">商品名と説明</div><hr>
        <div class="form__contents4-SubTitle">商品名</div>
        <input type="text" name="item_name" class="form__contents4-Input" value="{{old('item_name')}}">
        <div class="form__contents-error">
        @error('item_name')
          {{ $message }}
        @enderror
        </div>

        <div class="form__contents4-SubTitle">ブランド名</div>
        <input type="text" name="brand_name" class="form__contents4-Input" value="{{old('brand_name')}}">

        <div class="form__contents4-SubTitle">商品の説明</div>
        <textarea name="item_describe" class="form__contents4-Input2" rows="5">{{old('item_describe')}}</textarea>
        <div class="form__contents-error">
        @error('item_describe')
          {{ $message }}
        @enderror
        </div>

        <div class="form__contents4-SubTitle">販売価格</div>
        <div class="form__contents4-price">
          <span class="price-symbol">¥</span>
          <input type="text" name="price" class="form__contents4-InputPrice" value="{{ old('price')}}">
        </div>
        <div class="form__contents-error">
        @error('price')
          {{ $message }}
        @enderror
        </div>

      </div>

      <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
      <input type="hidden" name="image" value="{{ session('uploaded_file') }}">
      <button type="submit" class="button">出品する</button>
      </form>
    </div>
  </main>

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

  // カテゴリ
  document.querySelectorAll('.category-btn').forEach(button => {
    button.addEventListener('click', function() {
      const id = this.dataset.category;
      const input = document.querySelector(`input[name="category${id}"]`);
      const isOn = this.classList.contains('form__contents2-CategoryON');

      // 状態反転
      this.classList.toggle('form__contents2-CategoryON');
      this.classList.toggle('form__contents2-CategoryOFF');

      // hidden input に値反映（ON:1 / OFF:0）
      input.value = isOn ? 0 : 1;
    });
  });

</script>
@endsection
