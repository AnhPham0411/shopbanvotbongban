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
        <form action="{{ route('cart.update') }}" method="POST" id="cart-form">
            @csrf
            <table class="cart-table">
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;"><input type="checkbox" id="select-all" style="transform: scale(1.2); cursor: pointer;" title="Chọn tất cả"></th>
                        <th style="text-align:left;">Sản phẩm</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
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
                            <td style="text-align: center;">
                                <input type="checkbox" name="selected[]" value="{{ $id }}" class="item-checkbox" data-price="{{ $subtotal }}" style="transform: scale(1.2); cursor: pointer;">
                            </td>
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="cart-footer" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                <div class="cart-actions">
                    <button type="button" class="btn" id="btn-delete-selected" style="background-color: #dc3545; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; font-size: 1.4rem;">
                        Xóa đã chọn
                    </button>
                </div>
                <div class="cart-total" style="text-align: right;">
                    <div style="font-size: 1.3rem; color: #888; margin-bottom: 5px;">
                        Tổng giỏ hàng: {{ number_format($total, 0, ",", ".") }} đ
                    </div>
                    <div style="font-size: 1.6rem; font-weight: 500;">
                        Tổng thanh toán (<span id="selected-count">0</span>):
                        <span id="selected-total" style="color: #ee4d2d; font-size: 2.2rem; font-weight: bold; margin-left: 10px;">0 đ</span>
                    </div>
                </div>
                <div class="cart-buttons" style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn--normal">
                        Cập nhật
                    </button>
                    <a href="{{ route('home') }}" class="btn btn--normal">
                        ← Tiếp tục mua
                    </a>
                    <button type="button" class="btn btn--primary" id="btn-checkout">
                        Thanh toán
                    </button>
                </div>
            </div>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const selectAll = document.getElementById('select-all');
                const itemCheckboxes = document.querySelectorAll('.item-checkbox');
                const selectedCount = document.getElementById('selected-count');
                const selectedTotal = document.getElementById('selected-total');
                const btnDeleteSelected = document.getElementById('btn-delete-selected');
                const btnCheckout = document.getElementById('btn-checkout');
                const cartForm = document.getElementById('cart-form');

                function updateSummary() {
                    let count = 0;
                    let total = 0;
                    itemCheckboxes.forEach(cb => {
                        if (cb.checked) {
                            count++;
                            total += parseFloat(cb.dataset.price);
                        }
                    });
                    selectedCount.textContent = count;
                    selectedTotal.textContent = new Intl.NumberFormat('vi-VN').format(total) + ' đ';
                }

                selectAll.addEventListener('change', function() {
                    itemCheckboxes.forEach(cb => {
                        cb.checked = this.checked;
                    });
                    updateSummary();
                });

                itemCheckboxes.forEach(cb => {
                    cb.addEventListener('change', function() {
                        updateSummary();
                        const allChecked = Array.from(itemCheckboxes).every(c => c.checked);
                        selectAll.checked = allChecked;
                    });
                });

                btnDeleteSelected.addEventListener('click', function() {
                    const selected = Array.from(itemCheckboxes).filter(cb => cb.checked);
                    if (selected.length === 0) {
                        alert('Vui lòng chọn ít nhất một sản phẩm để xóa!');
                        return;
                    }
                    if (confirm('Bạn có chắc muốn xóa các sản phẩm đã chọn?')) {
                        cartForm.action = "{{ route('cart.remove_multiple') }}";
                        cartForm.method = "POST";
                        cartForm.submit();
                    }
                });

                btnCheckout.addEventListener('click', function() {
                    const selected = Array.from(itemCheckboxes).filter(cb => cb.checked);
                    if (selected.length === 0) {
                        alert('Vui lòng chọn ít nhất một sản phẩm để thanh toán!');
                        return;
                    }
                    let url = "{{ route('checkout') }}?";
                    selected.forEach(cb => {
                        url += `selected[]=${cb.value}&`;
                    });
                    window.location.href = url;
                });
            });
        </script>
    @endif
</div>
@endsection
