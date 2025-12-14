@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<main class="main-content">
    <div class="item-contents">
        @foreach ($items as $item)
        <div class="item-content">
            <a href="/items/detail/{{$item->id}}" class="item-link"></a>
            <img src="{{ asset($item->image) }}" alt="商品画像" class="img-content" />
            <div class="detail-content">
                <p>{{$item->name}}</p>
                <p class="price-content">￥{{$item->price}}</p>
            </div>
        </div>
        @endforeach
    </div>
</main>


@endsection
