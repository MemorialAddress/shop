@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/setProfile.css') }}" />
@endsection

@section('content')
  <title>プロフィール設定</title>

  <main>
    <div class="form">
      <div class="form__title">プロフィール設定</div>

      <div class="form__contents">

        <div class="form__contents-icon">
          <div class="form__contents-iconImage">
          @if(session('uploaded_file'))
              <img src="/storage/image/profile/{{ session('uploaded_file') }}">
          @else
              @if ($userAdd)
                <img src="/storage/image/profile/{{ $userAdd->image}}">
              @endif
          @endif
          </div>
          <form action="/upload" method="POST" enctype="multipart/form-data" class="form__contents-upload">
          @csrf
            <input type="file" name="image" id="fileInput" style="display:none">
            <button type="submit" id="customButton" class="form__contents-button">画像を選択する</button>
          </form>
        </div>
        <div class="form__contents-error">
          @error('image')
            {{ $message }}
          @enderror
        </div>

    <form action="/setProfile" method="post">
    @csrf
        <div class="form__contents-title">ユーザー名</div>
        <div class="form__contents-input">
          <input type="hidden" name="id" value="{{ Auth::user()->id }}">
          <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
          <input type="text" name="name" value="{{ Auth::user()->name }}">
          <div class="form__contents-error">
          @error('name')
            {{ $message }}
          @enderror
          </div>
        </div>

        <div class="form__contents-title">郵便番号</div>
        <div class="form__contents-input">
          @if ($userAdd)
              <input type="text" name="post_code" value="{{ old('post_code', $userAdd->post_code) }}">
          @else
              <input type="text" name="post_code" value="{{ old('post_code') }}">
          @endif
          <div class="form__contents-error">
          @error('post_code')
            {{ $message }}
          @enderror
          </div>
        </div>

        <div class="form__contents-title">住所</div>
        <div class="form__contents-input">
          @if ($userAdd)
              <input type="text" name="address" value="{{ old('address', $userAdd->address) }}">
          @else
              <input type="text" name="address" value="{{ old('address') }}">
          @endif
          <div class="form__contents-error">
          @error('address')
            {{ $message }}
          @enderror
          </div>
        </div>

        <div class="form__contents-title">建物名</div>
        <div class="form__contents-input">
          @if ($userAdd)
              <input type="text" name="building" value="{{ old('building', $userAdd->building) }}">
          @else
              <input type="text" name="building" value="{{ old('building') }}">
          @endif
          <div class="form__contents-error">
          @error('buliding')
            {{ $message }}
          @enderror
          </div>
        </div>

    </div>

    <div class="button">
      @if(session('uploaded_file'))
        <input type="hidden" name="image" value="{{ session('uploaded_file') }}">
      @else
        @if ($userAdd)
          <input type="hidden" name="image" value="{{ $userAdd->image}}">
        @endif
      @endif
      <button type="submit">更新する</button>
    </div>
    </form>

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
