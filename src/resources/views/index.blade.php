@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="tab-navigation">
        <a href="{{ route('items.index', ['tab' => 'recommended', 'keyword' => request('keyword')]) }}"
        class="tab-item {{ request('tab', 'recommended') == 'recommended' ? 'active' : '' }}">
        おすすめ
        </a>
        <a href="{{ route('items.index', ['tab' => 'mylist', 'keyword' => request('keyword')]) }}"
        class="tab-item {{ request('tab') == 'mylist' ? 'active' : '' }}">
        マイリスト
        </a>
    </div>
    <div class="item-contents">
        @foreach ($items as $item)
            <div class="item-content">
                <a href="{{ route('items.show', $item) }}" class="item-link"></a>
                <img src="{{ asset('storage/' . $item->image) }}" alt="商品画像" class="img-content" />
                <div class="detail-content">
                {{-- buyer_id があれば売り切れラベルを表示 --}}
                @if($item->status === \App\Models\Item::STATUS_SOLD)
                    <div class="sold-label">Sold</div>
                @endif
                <p class="item-name">{{$item->name}}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection