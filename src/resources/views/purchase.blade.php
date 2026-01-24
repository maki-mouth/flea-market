@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="purchase-main">
        <div class="product-info-section">
            <div class="product-image">
                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
            </div>
            <div class="product-detail">
                <div class="product-name">{{ $item->name }} </div>
                <p class="product-price">¥ {{ number_format($item->price) }} </p>
            </div>
        </div>
        <div class="setup-section">
            <div class="setup-item">
                <div class="setup-label">支払い方法 </div>
                @error('payment_method')
                    <div class="error">{{ $message }}</div>
                @enderror
                <div class="select-wrapper">
                    <select name="payment_method" form="purchase-form" id="payment-select">
                        <option value="" disabled {{ old('payment_method') ? '' : 'selected' }}>選択してください</option>
                        <option value="konbini" {{ old('payment_method') == 'konbini' ? 'selected' : '' }}>コンビニ払い </option>
                        <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>カード払い</option>
                    </select>
                </div>
            </div>
            <div class="setup-item">
                <div class="setup-header">
                    <div class="setup-label">配送先</div>
                    <a href="{{ route('address.edit', ['item' => $item->id]) }}" class="change-link">変更する</a>
                </div>
                @error('address')
                    <p class="error">{{ $message }}</p>
                @enderror
                <div class="address-display">
                    <input type="hidden" name="postal_code" value="{{ $user->profile->postal_code }}" form="purchase-form">
                    <input type="hidden" name="address" value="{{ $user->profile->address }}" form="purchase-form">
                    <input type="hidden" name="building" value="{{ $user->profile->building }}" form="purchase-form">
                    <p>〒{{ $user->profile->postal_code }}</p>
                    <p>{{ $user->profile->address }}{{ $user->profile->building }}</p>
                </div>
            </div>
        </div>
    </div>
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
    document.getElementById('payment-select').addEventListener('change', function() {
        const text = this.options[this.selectedIndex].text;
        document.getElementById('selected-payment').innerText = text;
    });
</script>
@endsection