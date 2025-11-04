@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/address.css') }}" />
@endsection

@section('content')
  <title>住所の変更</title>

  <main>
    <form action="/change" method="POST">
    @csrf
    <div class="form">
      <div class="form__title">住所の変更</div>

      <div class="form__contents">

        <div class="form__contents-title">郵便番号</div>
        <div class="form__contents-input">
          <input type="text" name="post_code" value="{{ old('post_code') }}">
          <div class="form__contents-error">
          @error('post_code')
            {{ $message }}
          @enderror
          </div>
        </div>

        <div class="form__contents-title">住所</div>
        <div class="form__contents-input">
          <input type="text" name="address">
          <div class="form__contents-error">
          @error('address')
            {{ $message }}
          @enderror
          </div>
        </div>

        <div class="form__contents-title">建物名</div>
        <div class="form__contents-input">
          <input type="text" name="building">
        </div>

    </div>

    <div class="button">
      @if(Auth::check())
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
      @endif
      <input type="hidden" name="item_id" value="{{ $item->id }}">
      <button type="submit">更新する</button>
    </div>
    </form>
@endsection
