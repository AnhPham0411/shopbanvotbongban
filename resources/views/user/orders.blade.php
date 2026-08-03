@extends('layouts.app')

@section('content')
<div class="grid">
    <div class="grid__row" style="margin-top: 20px;">
        <!-- Sidebar -->
        <div class="grid__column-2">
            <div style="background-color: #fff; padding: 15px; border-radius: 2px; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.1);">
                <div style="display: flex; align-items: center; padding-bottom: 15px; border-bottom: 1px solid #efefef; margin-bottom: 15px;">
                    <img src="{{ asset('assets/img/iconuser.png') }}" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">
                    <div>
                        <div style="font-weight: 600; font-size: 1.4rem;">{{ Auth::user()->name }}</div>
                        <div style="color: #888; font-size: 1.2rem;"><i class="fas fa-pen"></i> Sửa hồ sơ</div>
                    </div>
                </div>
                <ul style="list-style: none; padding-left: 0; margin: 0; font-size: 1.4rem;">
                    <li style="margin-bottom: 15px;"><a href="{{ route('profile') }}" style="color: #333; text-decoration: none;"><i class="fas fa-user" style="color: #1a94ff; width: 20px;"></i> Tài khoản của tôi</a></li>
                    <li style="margin-bottom: 15px;"><a href="{{ route('addresses.index') }}" style="color: #333; text-decoration: none;"><i class="fas fa-map-marker-alt" style="color: #1a94ff; width: 20px;"></i> Sổ địa chỉ</a></li>
                    <li style="margin-bottom: 15px;"><a href="{{ route('orders') }}" style="color: #ee4d2d; text-decoration: none;"><i class="fas fa-clipboard-list" style="color: #1a94ff; width: 20px;"></i> Đơn mua</a></li>
                    <li><a href="{{ route('favorites') }}" style="color: #333; text-decoration: none;"><i class="fas fa-heart" style="color: #1a94ff; width: 20px;"></i> Yêu thích</a></li>
                </ul>
            </div>
        </div>

        <!-- Content -->
        <div class="grid__column-10">
            <div style="background-color: #fff; padding: 20px; border-radius: 2px; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.1);">
                <div style="border-bottom: 1px solid #efefef; padding-bottom: 15px; margin-bottom: 20px;">
                    <h2 style="font-size: 1.8rem; font-weight: 500; margin: 0; color: #333;">Lịch Sử Đơn Hàng</h2>
                    <div style="font-size: 1.4rem; color: #555; margin-top: 5px;">Quản lý những đơn hàng bạn đã mua</div>
                </div>

                @if($orders->count() == 0)
                    <div style="text-align: center; padding: 50px 0; font-size: 1.6rem; color: #777;">
                        <i class="fas fa-box-open" style="font-size: 5rem; color: #ccc; margin-bottom: 15px; display: block;"></i>
                        Bạn chưa có đơn hàng nào.
                    </div>
                @else
                    @foreach($orders as $order)
                    <div style="border: 1px solid #e0e0e0; border-radius: 4px; margin-bottom: 20px; font-size: 1.4rem;">
                        <div style="background-color: #fafafa; padding: 15px; border-bottom: 1px solid #e0e0e0; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <span style="font-weight: bold; color: #333;">Đơn hàng #{{ $order->id }}</span>
                                <span style="color: #888; margin-left: 10px; font-size: 1.3rem;">Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div style="color: #ee4d2d; font-weight: bold; text-align: right;">
                                <div>
                                    @if($order->status == 'pending')
                                        Chờ xác nhận
                                    @elseif($order->status == 'confirmed')
                                        Đã xác nhận
                                    @elseif($order->status == 'packed')
                                        Đang đóng gói
                                    @elseif($order->status == 'shipping')
                                        Đang giao hàng
                                    @elseif($order->status == 'completed')
                                        Hoàn thành
                                    @elseif($order->status == 'cancelled')
                                        Đã hủy
                                    @else
                                        {{ $order->status }}
                                    @endif
                                </div>
                                @if($order->status == 'shipping')
                                <form action="{{ route('orders.confirm_received', $order->id) }}" method="POST" style="margin-top: 10px;">
                                    @csrf
                                    <button type="submit" style="background: #ee4d2d; color: #fff; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 1.3rem;">
                                        Đã nhận được hàng
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                        
                        <div style="padding: 15px;">
                            @foreach($order->items as $item)
                            <div style="display: flex; justify-content: space-between; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #f0f0f0;">
                                <div style="display: flex;">
                                    @php
                                        $img = $item->product->image ?? 'assets/img/default.png';
                                        if(!str_starts_with($img, 'uploads/') && !str_starts_with($img, 'assets/')) {
                                            $img = 'uploads/' . $img;
                                        }
                                    @endphp
                                    <img src="{{ asset($img) }}" style="width: 80px; height: 80px; object-fit: cover; border: 1px solid #eee; margin-right: 15px;">
                                    <div>
                                        <div style="font-size: 1.5rem; color: #333; margin-bottom: 5px;">{{ $item->name }}</div>
                                        <div style="color: #777;">x{{ $item->quantity }}</div>
                                        @if($order->status == 'completed' && $item->product_id)
                                            <div style="margin-top: 10px;">
                                                <a href="{{ route('product.detail', $item->product_id) }}#review-section" style="background: #fff; color: #ee4d2d; border: 1px solid #ee4d2d; padding: 5px 10px; border-radius: 2px; text-decoration: none; font-size: 1.2rem; display: inline-block;">Đánh giá</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div style="color: #ee4d2d; font-weight: 500;">
                                    {{ number_format($item->price, 0, ',', '.') }}đ
                                </div>
                            </div>
                            @endforeach
                            
                            <div style="text-align: right; margin-top: 15px; font-size: 1.6rem;">
                                Tổng tiền: <span style="color: #ee4d2d; font-weight: bold; font-size: 2rem;">{{ number_format($order->total, 0, ',', '.') }}đ</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
