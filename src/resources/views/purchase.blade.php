@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}" />
@endsection

@section('content')
    <title>商品購入</title>
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
                <div class="error" id="paymentError">
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
                    <div class="error" id="addressError">
                        @if($errors->has('purchase_post_code') || $errors->has('purchase_address'))
                            @if($errors->has('purchase_post_code'))
                                {{ $errors->first('purchase_post_code') }}
                            @elseif($errors->has('purchase_address'))
                                {{ $errors->first('purchase_address') }}
                            @endif
                        @endif
                    </div>
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
                <form action="/buy" method="POST" id="purchaseForm">
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
                    <button type="submit" id="butButton">購入する</button>
                </form>
            </div>
        </div>

    </div>

<script>
    const paymentSelect = document.getElementById('paymentSelect');
    const paymentDisplay = document.getElementById('selectedPayment');
    const paymentInput = document.getElementById('selectedPaymentInput');

    function updatePaymentDisplay() {
        const value = paymentSelect.value;
        paymentDisplay.textContent = value || '選択されていません';
        paymentInput.value = value; // hidden input にセット
    }

    paymentSelect.addEventListener('change', updatePaymentDisplay);
    updatePaymentDisplay();

    document.getElementById('purchaseForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const postCode = document.querySelector('input[name="purchase_post_code"]').value;
        const address  = document.querySelector('input[name="purchase_address"]').value;

        const paymentErrorDiv = document.getElementById('paymentError');
        const addressErrorDiv = document.getElementById('addressError');

        paymentErrorDiv.textContent = '';
        addressErrorDiv.textContent = '';

        let hasError = false;

        if (!paymentSelect.value) {
            paymentErrorDiv.textContent = '支払い方法を選択してください';
            hasError = true;
        }

        if (!postCode || !address) {
            addressErrorDiv.textContent = '配送先住所を入力してください';
            hasError = true;
        }

        if (hasError) return false;

        // hidden input にセット（Stripe 用）
        paymentInput.value = paymentSelect.value;

        const amount = {{ $item->price }};
        const itemId = {{ $item->id }};
        const userId = {{ Auth::user()->id }};
        const building = document.querySelector('input[name="purchase_building"]').value;

        const url = `/checkout.php`
            + `?amount=${amount}`
            + `&item_id=${itemId}`
            + `&user_id=${userId}`
            + `&post_code=${encodeURIComponent(postCode)}`
            + `&address=${encodeURIComponent(address)}`
            + `&building=${encodeURIComponent(building)}`
            + `&payment_method=${encodeURIComponent(paymentSelect.value)}`;

        window.location.href = url;
    });
</script>
@endsection
