@extends('admin.layouts.admin_app')

@section('title', 'Quản lý Đơn hàng')

@section('content')
<div style="background: #fff; padding: 25px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <h3 style="margin-top: 0; margin-bottom: 20px;">Danh sách Đơn hàng</h3>
    
    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
        <thead>
            <tr style="border-bottom: 2px solid #eee; background: #f9f9f9;">
                <th style="padding: 12px;">Mã ĐH</th>
                <th style="padding: 12px;">Khách hàng</th>
                <th style="padding: 12px;">Tổng tiền</th>
                <th style="padding: 12px;">Ngày đặt</th>
                <th style="padding: 12px;">Trạng thái</th>
                <th style="padding: 12px;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 12px;">#{{ $order->id }}</td>
                <td style="padding: 12px;">{{ $order->fullName }}</td>
                <td style="padding: 12px; color: #ee4d2d; font-weight: 500;">{{ number_format($order->total, 0, ',', '.') }}đ</td>
                <td style="padding: 12px;">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td style="padding: 12px;">
                    <span style="padding: 5px 10px; border-radius: 20px; font-size: 12px; background: {{ $order->status == 'pending' ? '#fff3e0' : '#e8f5e9' }}; color: {{ $order->status == 'pending' ? '#ff9800' : '#4caf50' }}; display: inline-block;">
                        {{ $order->status }}
                    </span>
                </td>
                <td style="padding: 12px; display: flex; gap: 5px;">
                    @if($order->status == 'pending')
                        <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST" style="margin: 0;">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="confirmed">
                            <button type="submit" style="background: #2196F3; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 13px;">Xác nhận đơn</button>
                        </form>
                        <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn này?');">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" style="background: #e74c3c; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 13px;">Hủy</button>
                        </form>
                    @elseif($order->status == 'confirmed')
                        <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST" style="margin: 0;">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="packed">
                            <button type="submit" style="background: #17a2b8; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 13px;">Đóng gói hàng</button>
                        </form>
                        <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn này?');">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" style="background: #e74c3c; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 13px;">Hủy</button>
                        </form>
                    @elseif($order->status == 'packed')
                        <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST" style="margin: 0;">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="shipping">
                            <button type="submit" style="background: #ff9800; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 13px;">Giao cho Shipper</button>
                        </form>
                    @elseif($order->status == 'shipping')
                        <span style="color: #888; font-style: italic; font-size: 13px;">Chờ khách nhận hàng...</span>
                    @elseif($order->status == 'completed')
                        <i class="fa-solid fa-check-circle" style="color: #4CAF50; font-size: 20px;"></i>
                    @elseif($order->status == 'cancelled')
                        <i class="fa-solid fa-times-circle" style="color: #e74c3c; font-size: 20px;"></i>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    

</div>
@endsection
