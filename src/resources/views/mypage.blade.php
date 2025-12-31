@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="mypage-container">
    {{-- ユーザー情報セクション --}}
    <div class="profile-header">
        <div class="profile-info">
            <div class="profile-avatar">
                @if($profile && $profile->profile_image)
                    <img src="{{ asset('storage/' . $profile->profile_image) }}" alt="ユーザー画像">
                @else
                    <div class="avatar-placeholder"></div>
                @endif
            </div>
            <h2 class="user-name">{{ $user->name }}</h2>
            <a href="{{ route('profile.edit') }}" class="btn-edit-profile">プロフィールを編集</a>
        </div>
    </div>

    {{-- タブメニューセクション --}}
    <div class="mypage-tabs">
        <div class="tab-item {{ $tab === 'sell' ? 'active' : '' }}">
            <a href="{{ route('mypage', ['tab' => 'sell']) }}">出品した商品</a>
        </div>
        <div class="tab-item {{ $tab === 'buy' ? 'active' : '' }}">
            <a href="{{ route('mypage', ['tab' => 'buy']) }}">購入した商品</a>
        </div>
    </div>
    {{-- 商品グリッドセクション --}}
    <div class="item-grid">
        @foreach($items as $item)
            <div class="item-card">
                <div class="item-image">
                    {{-- 商品画像がない場合のフォールバック --}}
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                    @else
                        <div class="image-placeholder">No Image</div>
                    @endif
                </div>
                <p class="item-name">{{ $item->name }}</p>
            </div>
        @endforeach
    </div>
</div>
@endsection