@extends('admin.layouts.admin_app')

@section('title', 'Tổng quan hệ thống')

@section('content')
<div style="background: #fff; padding: 25px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    
    <div class="row">
        <div class="col-3">
            <div style="background: #e8f5e9; padding: 20px; border-radius: 4px; text-align: center;">
                <i class="fa-solid fa-box" style="font-size: 30px; color: #4CAF50; margin-bottom: 10px;"></i>
                <h3 style="font-size: 16px; margin-bottom: 5px; margin-top: 0;">Tổng Sản Phẩm</h3>
                <span style="font-size: 24px; font-weight: bold; color: #333;">{{ \App\Models\Product::count() }}</span>
            </div>
        </div>
        
        <div class="col-3">
            <div style="background: #e3f2fd; padding: 20px; border-radius: 4px; text-align: center;">
                <i class="fa-solid fa-cart-arrow-down" style="font-size: 30px; color: #2196F3; margin-bottom: 10px;"></i>
                <h3 style="font-size: 16px; margin-bottom: 5px; margin-top: 0;">Đơn Hàng</h3>
                <span style="font-size: 24px; font-weight: bold; color: #333;">{{ \App\Models\Order::count() }}</span>
            </div>
        </div>
        
        <div class="col-3">
            <div style="background: #fff3e0; padding: 20px; border-radius: 4px; text-align: center;">
                <i class="fa-solid fa-users" style="font-size: 30px; color: #ff9800; margin-bottom: 10px;"></i>
                <h3 style="font-size: 16px; margin-bottom: 5px; margin-top: 0;">Người Dùng</h3>
                <span style="font-size: 24px; font-weight: bold; color: #333;">{{ \App\Models\User::count() }}</span>
            </div>
        </div>
        
        <div class="col-3">
            <div style="background: #fce4ec; padding: 20px; border-radius: 4px; text-align: center;">
                <i class="fa-solid fa-money-bill-wave" style="font-size: 30px; color: #e91e63; margin-bottom: 10px;"></i>
                <h3 style="font-size: 16px; margin-bottom: 5px; margin-top: 0;">Doanh Thu</h3>
                <span style="font-size: 24px; font-weight: bold; color: #333;">{{ number_format(\App\Models\Order::where('status', 'completed')->sum('total'), 0, ',', '.') }}đ</span>
            </div>
        </div>
    </div>

    <div style="margin-top: 40px;">
        <h3 style="font-size: 18px; margin-bottom: 15px; border-bottom: 2px solid #eee; padding-bottom: 10px;">10 Đơn hàng gần đây</h3>
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
            <thead>
                <tr style="border-bottom: 2px solid #eee; background: #f9f9f9;">
                    <th style="padding: 12px;">Mã ĐH</th>
                    <th style="padding: 12px;">Khách hàng</th>
                    <th style="padding: 12px;">Tổng tiền</th>
                    <th style="padding: 12px;">Ngày đặt</th>
                    <th style="padding: 12px;">Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @foreach(\App\Models\Order::orderBy('id', 'desc')->take(10)->get() as $order)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px;">#{{ $order->id }}</td>
                    <td style="padding: 12px;">{{ $order->fullName }}</td>
                    <td style="padding: 12px; color: #ee4d2d; font-weight: 500;">{{ number_format($order->total, 0, ',', '.') }}đ</td>
                    <td style="padding: 12px;">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td style="padding: 12px;">
                        <span style="padding: 5px 10px; border-radius: 20px; font-size: 12px; display: inline-block;
                            @if($order->status == 'pending') background: #fff3e0; color: #ff9800;
                            @elseif($order->status == 'cancelled') background: #ffebee; color: #f44336;
                            @else background: #e8f5e9; color: #4caf50; @endif">
                            @if($order->status == 'pending') Chờ xác nhận
                            @elseif($order->status == 'confirmed') Đã xác nhận
                            @elseif($order->status == 'packed') Đang đóng gói
                            @elseif($order->status == 'shipping') Đang giao hàng
                            @elseif($order->status == 'completed') Hoàn thành
                            @elseif($order->status == 'cancelled') Đã hủy
                            @else {{ $order->status }} @endif
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
