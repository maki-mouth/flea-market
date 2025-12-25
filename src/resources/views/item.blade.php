@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection

@section('content')
<div class="item-detail-container">
    <div class="item-image-section">
        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
    </div>

    <div class="item-info-section">
        <h1 class="item-name">{{ $item->name }}</h1>
        <p class="item-brand">{{ $item->brand }}</p>
        <p class="item-price">¥{{ number_format($item->price) }}(税込)</p>

        <div class="item-stats">
            <div class="stat-item">
                @php
                    // 開発用にID 1のユーザーでお気に入り済みか判定
                    $dummyUser = \App\Models\User::first();
                    $isLiked = $dummyUser ? $dummyUser->likedItems->contains($item->id) : false;
                @endphp
                    <form action="{{ route('like.store', $item) }}" method="POST">
                        @csrf
                        <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer;">
                            @if ($isLiked)
                                <img src="{{ asset('img/ハートロゴ_ピンク.png') }}" alt="いいね解除">
                            @else
                                <img src="{{ asset('img/ハートロゴ_デフォルト.png') }}" alt="いいね">
                            @endif
                        </button>
                    </form>
                <span>{{ $item->likedByUsers->count() }}</span>
            </div>
            <div class="stat-item">
                <img src="{{ asset('img/フキダシロゴ.png') }}" alt="フキダシロゴ">
                <span>1</span>
            </div>
        </div>

        <button class="buy-button">購入手続きへ</button>

        <div class="item-description">
            <h2>商品説明</h2>
            <p>{{ $item->description }}</p>
        </div>

        <div class="item-details-table">
            <h2>商品の情報</h2>
            <div class="detail-row">
                <span class="detail-label">カテゴリー</span>
                <span class="detail-value">
                    {{ $item->category->name ?? '未設定' }}
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">商品の状態</span>
                <span class="detail-value">
                    {{ $item->condition->name ?? '未設定' }}
                </span>
            </div>
        </div>

        <div class="comment-section">
            <h2>コメント(1)</h2>
            <div class="comment-item">
                <span class="comment-user">admin</span>
                <p class="comment-text">こちらにコメントが入ります。</p>
            </div>

            <div class="comment-form">
                <p>商品へのコメント</p>
                <textarea rows="4"></textarea>
                <button class="comment-submit">コメントを送信する</button>
            </div>
        </div>
    </div>
</div>
@endsection
