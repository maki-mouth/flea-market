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
            <h2 class="user-name">{{ $user->name }}</h2> {{-- [cite: 18] --}}
            <a href="{{ route('profile.edit') }}" class="btn-edit-profile">プロフィールを編集</a> {{-- [cite: 19] --}}
        </div>
    </div>

    {{-- タブメニューセクション --}}
    <div class="mypage-tabs">
        <div class="tab-item active">
            <a href="#">出品した商品</a> {{-- [cite: 16] --}}
        </div>
        <div class="tab-item">
            <a href="#">購入した商品</a> {{-- [cite: 17] --}}
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
                <p class="item-name">{{ $item->name }}</p> {{-- [cite: 24] --}}
            </div>
        @endforeach
    </div>
</div>
@endsection