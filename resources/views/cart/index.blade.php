@extends('layouts.app')

@section('content')
<div class="grid">
    @if(session('success'))
        <div class="alert" style="padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; color: #155724; background-color: #d4edda; border-color: #c3e6cb;">
            {{ session('success') }}
        </div>
    @endif

    @if(empty($cart))
        <div class="cart-empty">
            <img src="{{ asset('assets/img/empty-cart1690370236.png') }}" alt="">
            <h2>Giỏ hàng của bạn đang trống</h2>
            <a href="{{ route('home') }}" class="btn btn--primary">
                Mua sắm ngay
            </a>
        </div>
    @else
        <form action="{{ route('cart.update') }}" method="POST">
            @csrf
            <table class="cart-table">
                <thead>
                    <tr>
                        <th style="text-align:left;">Sản phẩm</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($cart as $id => $item)
                        @php
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td>
                                <div class="cart-product">
                                    <img src="{{ asset($item['image']) }}" class="cart-img">
                                    <div class="cart-info">
                                        <h3>{{ $item['name'] }}</h3>
                                        <p>{{ $item['brand'] ?? '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="cart-price">
                                {{ number_format($item['price'], 0, ",", ".") }} đ
                            </td>
                            <td>
                                <div class="cart-quantity">
                                    <input type="number" name="quantities[{{ $id }}]" value="{{ $item['quantity'] }}" min="1" style="width: 50px; text-align: center; border: 1px solid #ccc; outline: none; padding: 4px;">
                                </div>
                            </td>
                            <td class="cart-subtotal">
                                {{ number_format($subtotal, 0, ",", ".") }} đ
                            </td>
                            <td>
                                <button type="button" class="delete-btn" onclick="if(confirm('Bạn có chắc muốn xóa sản phẩm này?')) document.getElementById('remove-form-{{ $id }}').submit();" style="border: none; background: transparent; cursor: pointer;">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="cart-footer">
                <div class="cart-total">
                    Tổng thanh toán:
                    <span>
                        {{ number_format($total, 0, ",", ".") }} đ
                    </span>
                </div>
                <div class="cart-buttons">
                    <button type="submit" class="btn btn--normal">
                        Cập nhật
                    </button>
                    <a href="{{ route('home') }}" class="btn btn--normal">
                        ← Tiếp tục mua
                    </a>
                    <a href="{{ route('checkout') }}" class="btn btn--primary">
                        Thanh toán
                    </a>
                </div>
            </div>
        </form>

        @foreach($cart as $id => $item)
            <form id="remove-form-{{ $id }}" action="{{ route('cart.remove', $id) }}" method="POST" style="display: none;">
                @csrf
            </form>
        @endforeach
    @endif
</div>
@endsection
