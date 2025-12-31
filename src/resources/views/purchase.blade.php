@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="purchase-container">
    <div class="purchase-main">
        {{-- 商品情報 --}}
        <div class="product-info-section">
            <div class="product-image">
                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
            </div>
            <div class="product-detail">
                <h1 class="product-name">{{ $item->name }} </h1>
                <p class="product-price">¥ {{ number_format($item->price) }} </p>
            </div>
        </div>

        {{-- 設定セクション --}}
        <div class="setup-section">
            <div class="setup-item">
                <h2 class="setup-label">支払い方法 </h2>
                <div class="select-wrapper">
                    <select name="payment_method" form="purchase-form" id="payment-select">
                        <option value="" disabled selected>選択してください </option>
                        <option value="konbini">コンビニ払い </option>
                        <option value="card">カード払い</option>
                    </select>
                </div>
            </div>

            <div class="setup-item">
                <div class="setup-header">
                    <h2 class="setup-label">配送先 </h2>
                    <a href="{{ route('address.edit', ['item' => $item->id]) }}" class="change-link">変更する </a>
                </div>
                <div class="address-display">
                    <p>〒{{ $user->profile->postal_code }} </p>
                    <p>{{ $user->profile->address }}{{ $user->profile->building }} </p>
                </div>
            </div>
        </div>
    </div>

    {{-- サイドバー（確認・購入） --}}
    <aside class="purchase-sidebar">
        <table class="summary-table">
            <tr>
                <th>商品代金 </th>
                <td>¥ {{ number_format($item->price) }} </td>
            </tr>
            <tr>
                <th>支払い方法 </th>
                <td id="selected-payment">未選択</td>
            </tr>
        </table>

        <form action="{{ route('purchase.store', $item->id) }}" method="POST" id="purchase-form">
            @csrf
            <button type="submit" class="purchase-btn">購入する</button>
        </form>
    </aside>
</div>

<script>
    // 選択した支払い方法を右側に反映させる
    document.getElementById('payment-select').addEventListener('change', function() {
        const text = this.options[this.selectedIndex].text;
        document.getElementById('selected-payment').innerText = text;
    });
</script>
@endsection