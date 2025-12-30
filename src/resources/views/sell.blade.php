@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="sell-container">
    <h1 class="sell-title">商品の出品</h1>

    <form action="{{ route('sell.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- 商品画像 --}}
        <div class="form-group">
            <label class="section-title">商品画像</label>
            <div class="image-upload-area">
                <div id="image-preview-container" class="image-preview">
                    {{-- プレビュー画像がここに表示されます --}}
                </div>
                <label class="image-select-btn">
                    画像を選択する
                    <input type="file" name="image" id="item-image" accept="image/*" style="display:none;">
                </label>
            </div>
            @error('image') <p class="error-msg">{{ $message }}</p> @enderror
        </div>

        {{-- 商品の詳細 --}}
        <div class="form-section">
            <h2 class="section-sub-title">商品の詳細</h2>
            
            <div class="form-group">
                <label>カテゴリー</label>
                <div class="category-grid">
                    @foreach($categories as $category)
                    <label class="category-item">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}">
                        <span>{{ $category->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label for="condition_id">商品の状態</label>
                <div class="select-wrapper">
                    <select name="condition_id" id="condition_id">
                        <option value="" disabled selected>選択してください</option>
                        @foreach($conditions as $condition)
                            <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- 商品名と説明 --}}
        <div class="form-section">
            <h2 class="section-sub-title">商品名と説明</h2>
            <div class="form-group">
                <label for="name">商品名</label>
                <input type="text" name="name" id="name">
            </div>
            <div class="form-group">
                <label for="brand">ブランド名</label>
                <input type="text" name="brand" id="brand">
            </div>
            <div class="form-group">
                <label for="description">商品の説明</label>
                <textarea name="description" id="description" rows="5"></textarea>
            </div>
        </div>

        {{-- 販売価格 --}}
        <div class="form-section">
            <h2 class="section-sub-title">販売価格</h2>
            <div class="form-group">
                <label for="price">販売価格</label>
                <div class="price-input-container">
                    <span class="currency-unit">¥</span>
                    <input type="number" name="price" id="price" placeholder="0">
                </div>
            </div>
        </div>

        <button type="submit" class="submit-btn">出品する</button>
    </form>
</div>

<script>
    // 画像プレビュー処理
    document.getElementById('item-image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const container = document.getElementById('image-preview-container');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                container.innerHTML = `<img src="${e.target.result}" style="max-width:100%; height:auto;">`;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection