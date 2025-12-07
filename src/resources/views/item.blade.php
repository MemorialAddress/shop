@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item.css') }}" />
@endsection

@section('content')
    <title>商品詳細</title>

    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <table class="item">
        <tr>
            <th class="item__th">
                <img class="item__th-image" src="/storage/image/item/{{ $item->image}}">
            </th>
            <th class="item__th">
                <p class="item__th-item-name">{{ $item -> item_name }}</p>
                <p class="item__th-item-brand">{{ $item -> brand_name }}</p>
                <p class="item__th-item-price">
                    <span style="font-size: 30px;">￥</span>
                    {{ number_format($item->price) }}
                    <span style="font-size: 30px;">(税込)</span>
                </p>
                <table class="item__sub">
                    <tr class="item__sub-tr1">
                        <form action="/item/{{ $item->id }}" method="POST">
                        @csrf
                        @if(Auth::check())
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        @endif
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <th class="item__sub-image">
                            @if ($favorite ==true)
                                <button class="item__sub-button"><image src="/image/star_good.png"></button>
                            @else
                                <button class="item__sub-button"><image src="/image/star_normal.png"></button>
                            @endif
                        </th>
                        </form>
                        <th class="item__sub-image">
                            <button class="item__sub-button"><image src="/image/comment.png"></button>
                        </th>
                    </tr>
                    <tr class="item__sub-tr2">
                        <th class="item__sub-count">{{ \App\Models\Favorite::where('item_id', $item->id)->count() }}</th>
                        <th class="item__sub-count">{{ \App\Models\Items_comment::where('item_id', $item->id)->count() }}</th>
                    </tr>
                </table>
                @if(in_array($item->id, $purchasedItemIds))
                <p class="item__th-item-purchase">
                    <button disabled class="button__off">SOLD OUT</button>
                </p>
                @else
                <form action="/purchase/{{ $item->id }}" method="POST">
                    @csrf
                    @if(Auth::check())
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    @endif
                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                    <button class="button__on">購入手続きへ</button>
                </form>
                @endif
                <p class="item__th-item-describe-title">商品説明</p>
                <p class="item__th-item-describe-text">{{ $item -> item_describe }}</p>
                <p class="item__th-item-info">商品の情報</p>
                <table class="item__sub2">
                    <tr class="item__sub2-tr">
                        <th class="item__sub2-categoryTitle">カテゴリー</th>
                        <th class="item__sub2-category">
                            @if ( is_string($item->category1) && $item->category1 !== '')
                                <span class="item__sub2-categoryName">{{ $item -> category1 }}</span>
                            @endif
                            @if ( is_string($item->category2) && $item->category2 !== '')
                                <span class="item__sub2-categoryName">{{ $item -> category2 }}</span>
                            @endif
                            @if  ( is_string($item->category3) && $item->category3 !== '')
                                <span class="item__sub2-categoryName">{{ $item -> category3 }}</span>
                            @endif
                            @if  ( is_string($item->category4) && $item->category4 !== '')
                                <span class="item__sub2-categoryName">{{ $item -> category4 }}</span>
                            @endif
                            @if  ( is_string($item->category5) && $item->category5 !== '')
                                <span class="item__sub2-categoryName">{{ $item -> category5 }}</span>
                            @endif
                            @if  ( is_string($item->category6) && $item->category6 !== '')
                                <span class="item__sub2-categoryName">{{ $item -> category6 }}</span>
                            @endif
                            @if  ( is_string($item->category7) && $item->category7 !== '')
                                <span class="item__sub2-categoryName">{{ $item -> category7 }}</span>
                            @endif
                            @if  ( is_string($item->category8) && $item->category8 !== '')
                                <span class="item__sub2-categoryName">{{ $item -> category8 }}</span>
                            @endif
                            @if  ( is_string($item->category9) && $item->category9 !== '')
                                <span class="item__sub2-categoryName">{{ $item -> category9 }}</span>
                            @endif
                            @if  ( is_string($item->category10) && $item->category10 !== '')
                                <span class="item__sub2-categoryName">{{ $item -> category10 }}</span>
                            @endif
                            @if  ( is_string($item->category11) && $item->category11 !== '')
                                <span class="item__sub2-categoryName">{{ $item -> category11 }}</span>
                            @endif
                            @if  ( is_string($item->category12) && $item->category12 !== '')
                                <span class="item__sub2-categoryName">{{ $item -> category12 }}</span>
                            @endif
                            @if  ( is_string($item->category13) && $item->category13 !== '')
                                <span class="item__sub2-categoryName">{{ $item -> category13 }}</span>
                            @endif
                            @if  ( is_string($item->category14) && $item->category14 !== '')
                                <span class="item__sub2-categoryName">{{ $item -> category14 }}</span>
                            @endif
                        </th>
                    </tr>
                    <tr class="item__sub2-tr">
                        <th class="item__sub2-conditionTitle">商品の状態</th>
                        <th class="item__sub2-condition">{{ $item -> condition }}</th>
                    </tr>
                </table>
                <p class="item__th-item-comment">コメント（{{ \App\Models\Items_comment::where('item_id', $item->id)->count() }}）</p>

                @foreach ($item_comment as $comment)
                <table class="table__comment">
                <tr class="table__comment-tr">
                    @php
                    $userImage = \App\Models\UsersAdd::where('user_id', $comment->user_id)->value('image');
                    @endphp
                    <th class="item__th-item-commentImg"><img src="/storage/image/profile/{{ $userImage }}"></th>
                    <th class="item__th-item-commentUser">
                    {{ \App\Models\User::where('id', $comment -> user_id )->value('name'); }}
                    </th>
                </tr>
                <tr class="table__comment-trBlank"></tr>
                <tr class="table__comment-tr">
                    <th class="item__th-item-commentText" colspan="2">{{ $comment -> comment }}</th>
                </tr>
                </table>
                @endforeach

                <p class="item__th-item-commenterTitle">商品へのコメント</p>
                <form action="/comment" method="POST">
                @csrf
                <p class="item__th-item-commenterForm">
                    <textarea name="comment">{{ old('comment') }}</textarea>
                    @if(Auth::check())
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    @endif
                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                </p>

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                    <p class = "error">{{ $error }}</p>
                    @endforeach
                @endif

                @if(in_array($item->id, $purchasedItemIds))
                <p class="item__th-item-commenter">
                    <button disabled class="button__off">購入済みにつきコメントできません</button>
                </p>
                @else
                <p class="item__th-item-commenter">
                    <button class="button__on">コメントを送信する</button>
                </p>
                @endif
                </form>
            </th>
        </tr>
    </table>
@endsection
