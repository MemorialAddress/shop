@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('content')
    <title>商品一覧</title>

    <div class="tab">
        <form class="tab__recommend" action="/" method="get">
            <button class="tab__recommend-button" style="color: {{ ($tab ?? '') === '' ? 'red' : '#5F5F5F' }}">
                おすすめ
            </button>
        </form>
        <form class="tab__mylist" action="/" method="get">
            <input type="hidden" name="tab" value="mylist">
            <button class="tab__mylist-button" style="color: {{ ($tab ?? '') === 'mylist' ? 'red' : '#5F5F5F' }}">
                マイリスト
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
                                    <img class="table__td-image" alt="{{ $item['item_name'] }}" src="storage/image/item/{{ $item['id'] }}.png">
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
