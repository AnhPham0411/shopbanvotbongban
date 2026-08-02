@extends('layouts.app')

@section('content')
<div class="grid">
    @if(session('error'))
        <div class="alert" style="padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; color: #721c24; background-color: #f8d7da; border-color: #f5c6cb;">
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div class="alert" style="padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; color: #155724; background-color: #d4edda; border-color: #c3e6cb;">
            {{ session('success') }}
        </div>
    @endif

    <div class="checkout">
        <!-- Bên trái -->
        <div class="checkout-left">
            <h2>Thông tin nhận hàng</h2>
            <form action="{{ route('checkout.place') }}" method="POST">
                @csrf
                <label>Họ và tên</label>
                <input type="text" name="fullName" value="{{ Auth::check() ? Auth::user()->name : '' }}" required>

                <label>Số điện thoại</label>
                <input type="text" name="phone" value="{{ Auth::check() ? Auth::user()->phone : '' }}" required>

                <label>Địa chỉ nhận hàng</label>
                <textarea name="address" required>{{ Auth::check() ? Auth::user()->address : '' }}</textarea>
                
                <label>Phương thức thanh toán</label>
                <select name="paymentMethod" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 15px;">
                    <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                    <option value="bank">Chuyển khoản ngân hàng</option>
                </select>
                
                <label>Ghi chú (Tùy chọn)</label>
                <textarea name="note"></textarea>

                <button type="submit" class="btn btn--primary checkout-btn">
                    Đặt hàng
                </button>
            </form>
        </div>

        <!-- Bên phải -->
        <div class="checkout-right">
            <h2>Đơn hàng</h2>
            @php $total = 0; @endphp
            @foreach($cart as $item)
                @php $total += $item['price'] * $item['quantity']; @endphp
                <div class="checkout-item">
                    <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}">
                    <div class="checkout-info">
                        <h4>{{ $item['name'] }}</h4>
                        <p>
                            {{ number_format($item['price'], 0, ",", ".") }}đ
                            ×
                            {{ $item['quantity'] }}
                        </p>
                    </div>
                </div>
            @endforeach
            <hr>

            <!-- Khung nhập mã giảm giá -->
            <div style="margin: 15px 0; background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #eee;">
                <h3 style="font-size: 1.5rem; margin-top: 0; margin-bottom: 15px; color: #333;"><i class="fa-solid fa-ticket" style="color: #ee4d2d; margin-right: 5px;"></i> Mã giảm giá</h3>
                
                @if($coupon)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 15px; background: #f0fdf4; border: 1px dashed #22c55e; border-radius: 6px;">
                        <div style="display: flex; flex-direction: column;">
                            <span style="font-weight: 700; color: #15803d; font-size: 1.4rem;">{{ $coupon['code'] }}</span> 
                            <span style="font-size: 1.2rem; color: #166534; margin-top: 4px;">Đã giảm {{ $coupon['type'] == 'percent' ? $coupon['value'].'%' : number_format($coupon['value'], 0, ',', '.').'đ' }}</span>
                        </div>
                        <form action="{{ route('coupon.remove') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" style="background: #fee2e2; border: 1px solid #f87171; color: #dc2626; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 1.2rem; font-weight: 600; transition: all 0.2s;"><i class="fas fa-times"></i> Gỡ bỏ</button>
                        </form>
                    </div>
                @else
                    <form action="{{ route('coupon.apply') }}" method="POST" style="display: flex; gap: 10px; margin-bottom: 15px;">
                        @csrf
                        <input type="text" name="code" placeholder="Nhập mã của bạn..." style="flex: 1; padding: 10px 15px; border: 1px solid #ddd; border-radius: 4px; font-size: 1.3rem; outline: none;">
                        <button type="submit" style="padding: 10px 20px; background: #ee4d2d; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 1.3rem;">Áp dụng</button>
                    </form>

                    <!-- Danh sách mã có sẵn -->
                    @if(isset($availableCoupons) && $availableCoupons->count() > 0)
                        <style>
                            .coupon-ticket {
                                display: flex;
                                background: #fff;
                                border: 1px solid #fecaca;
                                border-radius: 4px;
                                position: relative;
                                margin-bottom: 12px;
                                box-shadow: 0 2px 4px rgba(0,0,0,0.04);
                            }
                            .coupon-ticket.disabled {
                                border-color: #eee;
                                background: #fafafa;
                            }
                            .coupon-left {
                                background: linear-gradient(135deg, #f53d2d, #ff6633);
                                color: #fff;
                                width: 90px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                flex-direction: column;
                                position: relative;
                                border-right: 2px dashed #fff;
                            }
                            .coupon-ticket.disabled .coupon-left {
                                background: #ccc;
                            }
                            .coupon-left::before, .coupon-left::after {
                                content: '';
                                position: absolute;
                                right: -7px;
                                width: 14px;
                                height: 14px;
                                background: #fff;
                                border-radius: 50%;
                                z-index: 1;
                            }
                            .coupon-left::before {
                                top: -7px;
                                border-bottom: 1px solid #fecaca;
                            }
                            .coupon-left::after {
                                bottom: -7px;
                                border-top: 1px solid #fecaca;
                            }
                            .coupon-ticket.disabled .coupon-left::before { border-color: #eee; }
                            .coupon-ticket.disabled .coupon-left::after { border-color: #eee; }
                            
                            .coupon-right {
                                padding: 12px;
                                flex: 1;
                                display: flex;
                                justify-content: space-between;
                                align-items: center;
                            }
                            .btn-apply-coupon {
                                background: #ee4d2d;
                                color: #fff;
                                border: none;
                                padding: 6px 14px;
                                border-radius: 4px;
                                cursor: pointer;
                                font-size: 1.3rem;
                                font-weight: 500;
                                transition: 0.2s;
                            }
                            .btn-apply-coupon:hover {
                                background: #d73d22;
                            }
                        </style>
                        <div style="font-size: 1.4rem; color: #555; margin-bottom: 12px; font-weight: 500;">Mã khuyến mãi dành cho bạn:</div>
                        <div style="display: flex; flex-direction: column; max-height: 300px; overflow-y: auto; padding-right: 5px; margin-bottom: -12px;">
                            @foreach($availableCoupons as $avCoupon)
                                @php
                                    $isValid = $total >= $avCoupon->min_order_value;
                                @endphp
                                <div class="coupon-ticket {{ $isValid ? '' : 'disabled' }}">
                                    <div class="coupon-left">
                                        <i class="fa-solid fa-tags" style="font-size: 2.4rem; margin-bottom: 5px;"></i>
                                        <span style="font-size: 1.2rem; font-weight: bold;">Mã giảm</span>
                                    </div>
                                    <div class="coupon-right">
                                        <div>
                                            <div style="font-weight: bold; color: {{ $isValid ? '#ee4d2d' : '#999' }}; font-size: 1.5rem; margin-bottom: 4px; text-transform: uppercase;">{{ $avCoupon->code }}</div>
                                            <div style="font-size: 1.3rem; color: #444; margin-bottom: 4px;">
                                                Giảm {{ $avCoupon->type == 'percent' ? $avCoupon->value.'%' : number_format($avCoupon->value, 0, ',', '.').'đ' }} 
                                            </div>
                                            <div style="font-size: 1.2rem; color: #888;">
                                                Đơn tối thiểu {{ number_format($avCoupon->min_order_value, 0, ',', '.') }}đ
                                            </div>
                                        </div>
                                        
                                        @if($isValid)
                                            <form action="{{ route('coupon.apply') }}" method="POST" style="margin: 0;">
                                                @csrf
                                                <input type="hidden" name="code" value="{{ $avCoupon->code }}">
                                                <button type="submit" class="btn-apply-coupon">Dùng ngay</button>
                                            </form>
                                        @else
                                            <button disabled style="background: transparent; color: #999; border: 1px solid #ddd; padding: 6px 10px; border-radius: 4px; cursor: not-allowed; font-size: 1.2rem;">Chưa đạt</button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif
            </div>

            <hr>
            <div style="margin-top: 15px; padding: 15px; background: #fff; border-radius: 8px; border: 1px solid #eee; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 1.4rem; color: #555;">
                    <span>Tạm tính</span>
                    <span>{{ number_format($total, 0, ",", ".") }}đ</span>
                </div>
                @if($discountAmount > 0)
                <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 1.4rem; color: #22c55e;">
                    <span>Khuyến mãi (Mã giảm giá)</span>
                    <span>-{{ number_format($discountAmount, 0, ",", ".") }}đ</span>
                </div>
                @endif
                <div style="display: flex; justify-content: space-between; align-items: flex-end; font-size: 1.8rem; margin-top: 15px; border-top: 1px dashed #ddd; padding-top: 15px;">
                    <span style="color: #333; font-size: 1.6rem; font-weight: 500;">Tổng thanh toán</span>
                    <strong style="color: #ee4d2d; font-size: 2.2rem;">
                        {{ number_format(max(0, $total - $discountAmount), 0, ",", ".") }}đ
                    </strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
