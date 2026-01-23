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
            <div class="item-stat">
                    <form action="{{ route('like.store', $item) }}" method="POST">
                        @csrf
                        <button type="submit">
                            @if (Auth::check() && Auth::user()->likedItems->contains($item->id))
                                <img src="{{ asset('img/ハートロゴ_ピンク.png') }}" alt="いいね解除">
                            @else
                                <img src="{{ asset('img/ハートロゴ_デフォルト.png') }}" alt="いいね">
                            @endif
                        </button>
                    </form>
                <span>{{ $item->likedByUsers->count() }}</span>
            </div>
            <div class="item-stat">
                <img src="{{ asset('img/フキダシロゴ.png') }}" alt="フキダシロゴ">
                <span>{{ $item->comments->count() }}</span>
            </div>
        </div>
        <div class="detail-actions">
            @if($item->status === \App\Models\Item::STATUS_SOLD)
                <button class="sold-out-button" disabled>売り切れました</button>
            @else
                <a href="{{ route('purchase.show', $item->id) }}" class="buy-button">購入手続きへ</a>
            @endif
        </div>
        <div class="item-description">
            <h2>商品説明</h2>
            <p class="item-description-text">{{ $item->description }}</p>
        </div>
        <div class="item-details-table">
            <h2>商品の情報</h2>
            <div class="detail-row">
                <span class="detail-label">カテゴリー</span>
                @foreach($item->categories as $category)
                <span class="detail-value-tag">
                    {{ $category->name ?? '未設定' }}
                </span>
                @endforeach
            </div>
            <div class="detail-row">
                <span class="detail-label">商品の状態</span>
                <span class="detail-value">
                    {{ $item->condition->name ?? '未設定' }}
                </span>
            </div>
        </div>
        <div class="comment-section">
            <h2>コメント ({{ $item->comments->count() }})</h2>
            @foreach($item->comments as $comment)
            <div class="comment-item">
                <div class="comment-user">
                    {{-- プロフィール画像を表示 --}}
                    @if($comment->user->profile && $comment->user->profile->profile_image)
                        <img src="{{ asset('storage/' . $comment->user->profile->profile_image) }}" class="avatar">
                    @endif
                    <span>{{ $comment->user->name }}</span>
                </div>
                <p class="comment-text">{{ $comment->comment }}</p>
            </div>
            @endforeach
            <div class="comment-form">
                @auth
                <form action="{{ route('comment.store', $item->id) }}" method="POST">
                @csrf
                    <p class="comment-form-label">商品へのコメント</p>
                    <textarea name="comment" placeholder="コメントを入力してください"></textarea>
                    @error('comment')
                        <a class="error">{{ $message }}</a>
                    @enderror
                    <button class="comment-submit">コメントを送信する</button>
                </form>
                @else
                <form action="{{ route('login') }}" method="POST">
                @csrf
                    <p class="comment-form-label">商品へのコメント</p>
                    <textarea name="comment" placeholder="コメントを入力してください"></textarea>
                    <button class="comment-submit">コメントを送信する</button>
                </form>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
