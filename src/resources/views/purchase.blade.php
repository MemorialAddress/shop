@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}" />
@endsection

@section('content')
    <title>商品一覧</title>
    <div class="purchase">
        <div class="left">
            <div class="left__area1">
                <div class="left__area1-image">
                    <img class="item__th-image" src="/storage/image/item/{{ $item->image}}">
                </div>
                <div class="left__area1-item">
                    <div class="left__area1-itemName">{{ $item->item_name }}</div><br>
                    <div class="left__area1-itemPrice">￥{{ number_format($item->price) }}</div>
                </div>
            </div>

            <hr>

            <div class="left__area2">
                <div class="left__area2-paymentMethod">支払い方法</div>
                <select id="paymentSelect" name="payment_method">
                    <option value="" selected>選択してください</option>
                    <option value="コンビニ払い">コンビニ払い</option>
                    <option value="カード支払い">カード支払い</option>
                </select>
                <div class="error">
                @error('payment_method')
                    {{ $message }}
                @enderror
                </div>
            </div>

            <hr>

            <div class="left__area3">
                <div class="left__area3-title">
                    <div class="left__area3-address">配送先</div>
                    <form action="/purchase/address/{{ $item->id }}" method="POST">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item['id'] }}">
                        <button type="submit" class="left__area3-addressChange">
                            変更する
                        </button>
                    </form>
                </div>
                <div class="left__area3-addressDetail">
                    @if  ( session('other_flg') == '1')
                        <div class="left__area3-addressDetail-text">{{ session('other_post_code') }}</div>
                        <div class="left__area3-addressDetail-text">{{ session('other_address') }}</div>
                        <div class="left__area3-addressDetail-text">{{ session('other_building') }}</div>
                    @else
                        <div class="left__area3-addressDetail-text">
                        @if ($useradd)
                            <div class="left__area3-addressDetail-text">{{ $useradd->post_code }}</div>
                            <div class="left__area3-addressDetail-text">{{ $useradd->address }}</div>
                            <div class="left__area3-addressDetail-text">{{ $useradd->building }}</div>
                        @else
                            <div class="left__area3-addressDetail-text">{{ old('purchase_post_code')}}</div>
                            <div class="left__area3-addressDetail-text">{{ old('purchase_address')}}</div>
                            <div class="left__area3-addressDetail-text">{{ old('purchase_building')}}</div>
                        @endif
                        </div>
                    @endif
                </div>
            <hr><br><br><br>
            </div>
        </div>


        <div class="right">
            <div class="right__area1">
                <table class="right__area1-table">
                    <tr class="right__area1-tr">
                        <th class="right__area1-title">商品代金</th>
                        <th class="right__area1-detail">￥{{ number_format($item->price) }}</th>
                    </tr>
                    <tr class="right__area1-tr">
                        <th class="right__area1-title">支払い方法</th>
                        <th class="right__area1-detail" id="selectedPayment"></th>
                    </tr>
                </table>
            </div>
            <div class="right__area2">
                <form action="/buy" method="POST">
                @csrf
                    <input type="hidden" name="item_id" value="{{ $item['id'] }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="payment_method" id="selectedPaymentInput">
                    @if  ( session('other_flg') == '1')
                        <input type="hidden" name="purchase_post_code" value="{{ session('other_post_code') }}">
                        <input type="hidden" name="purchase_address"   value="{{ session('other_address') }}">
                        <input type="hidden" name="purchase_building"  value="{{ session('other_building') }}">
                    @else
                        @if ($useradd)
                            <input type="hidden" name="purchase_post_code" value="{{ $useradd->post_code }}">
                            <input type="hidden" name="purchase_address" value="{{ $useradd->address }}">
                            <input type="hidden" name="purchase_building" value="{{$useradd->building }}">
                        @else
                            <input type="hidden" name="purchase_post_code" value="{{ old('purchase_post_code') }}">
                            <input type="hidden" name="purchase_address" value="{{ old('purchase_address') }}">
                            <input type="hidden" name="purchase_building" value="{{ old('purchase_building') }}">
                        @endif
                    @endif
                    <button type="submit">購入する</button>
                </form>
            </div>
        </div>

    </div>

<script>
    document.getElementById('paymentSelect').addEventListener('change', function() {
        const selected = this.value || '選択されていません';
        document.getElementById('selectedPayment').textContent = selected;
        document.getElementById('selectedPaymentInput').value = selected;
    });
</script>
@endsection
