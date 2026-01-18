@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="address-container">
        <div class="address-title">住所の変更</div>
        <form action="{{ route('address.update', ['item' => $item_id]) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label for="postal_code">郵便番号</label>
                <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $user->profile->postal_code ?? '') }}">
                @error('postal_code') <a class="error">{{ $message }}</a> @enderror
            </div>
            <div class="form-group">
                <label for="address">住所</label>
                <input type="text" name="address" id="address" value="{{ old('address', $user->profile->address ?? '') }}">
                @error('address') <a class="error">{{ $message }}</a> @enderror
            </div>
            <div class="form-group">
                <label for="building">建物名</label>
                <input type="text" name="building" id="building" value="{{ old('building', $user->profile->building ?? '') }}">
            </div>
            <button type="submit" class="submit-btn">更新する</button>
        </form>
    </div>
</div>
@endsection