@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}" />
@endsection

@section('content')
    <title>プロフィール画面</title>
    <div class="user">
        <img src="/storage/image/profile/{{ $userAdd->image}}">
        <div class="user__name">{{ $users -> name }}</div>
        <form action="/mypage/profile" method="GET">
            <button>プロフィールを編集</button>
        </form>
    </div>

    <div class="tab">
        <form class="tab__recommend" action="/mypage" method="get">
            <input type="hidden" name="page" value="sell">
            <button class="tab__recommend-button" style="color: {{ ($page ?? 'sell') === 'sell' ? 'red' : '#5F5F5F' }}">
                出品した商品
            </button>
        </form>
        <form class="tab__mylist" action="/mypage" method="get">
            <input type="hidden" name="page" value="buy">
            <button class="tab__mylist-button" style="color: {{ ($page ?? 'sell') === 'buy' ? 'red' : '#5F5F5F' }}">
                購入した商品
            </button>
        </form>
    </div>

    <hr>

    <form action="/item" method="get">
    @csrf
        <div class="items">
            <table>
                @foreach ($items->chunk(4) as $chunk)
                    <tr class="table__tr">
                        @foreach ($chunk as $item)
                            <td class="table__td">
                            <form action="/item/{{ $item->id }}" method="GET">
                                <input type="hidden" name="id" value="{{ $item['id'] }}">
                                <a href="{{ url('/item/'.$item->id) }}" class="table__td-card">
                                    <img class="table__td-image" alt="{{ $item['item_name'] }}" src="storage/image/item/{{ $item->image}}">
                                    <p class="table__td-name">
                                        @if(in_array($item->id, $purchasedItemIds))
                                            <span style="color:red">[Sold]</span>
                                        @endif
                                        {{ $item['item_name'] }}
                                    </p>
                                </a>
                            </form>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </table>
        </div>
@endsection
