@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="tab-navigation">
    <a href="{{ route('items.index', ['tab' => 'recommended']) }}"
    class="tab-item {{ request('tab', 'recommended') == 'recommended' ? 'active' : '' }}">
    おすすめ
    </a>
    <a href="{{ route('items.index', ['tab' => 'mylist']) }}"
    class="tab-item {{ request('tab') == 'mylist' ? 'active' : '' }}">
    マイリスト
    </a>
</div>
<hr class="tab-underline">
<main class="main-content">
    <div class="item-contents">
        @foreach ($items as $item)
        <div class="item-content">
            <a href="{{ route('items.show', $item) }}" class="item-link"></a>
            <img src="{{ asset('storage/' . $item->image) }}" alt="商品画像" class="img-content" />
            <div class="detail-content">
                <p class="item-name">{{$item->name}}</p>
            </div>
        </div>
        @endforeach
    </div>
</main>
@endsection
