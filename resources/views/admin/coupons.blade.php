@extends('admin.layouts.admin_app')

@section('title', 'Quản lý Mã giảm giá')

@section('content')
<div style="background: #fff; padding: 25px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3 style="margin: 0;">Danh sách Mã giảm giá</h3>
        <a href="{{ route('admin.coupons.create') }}" style="background: #4CAF50; color: #fff; text-decoration: none; padding: 10px 15px; border-radius: 4px; display: inline-block;">
            <i class="fa-solid fa-plus"></i> Thêm mã mới
        </a>
    </div>
    
    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
        <thead>
            <tr style="background: #f4f6f9; border-bottom: 2px solid #ddd;">
                <th style="padding: 12px; width: 50px;">ID</th>
                <th style="padding: 12px;">Mã CODE</th>
                <th style="padding: 12px;">Giá trị giảm</th>
                <th style="padding: 12px;">Đơn tối thiểu</th>
                <th style="padding: 12px;">Đã dùng / Giới hạn</th>
                <th style="padding: 12px;">Ngày hết hạn</th>
                <th style="padding: 12px;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($coupons as $coupon)
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 12px;">#{{ $coupon->id }}</td>
                <td style="padding: 12px; font-weight: bold; color: #2196F3;">{{ $coupon->code }}</td>
                <td style="padding: 12px; color: #ee4d2d; font-weight: 500;">
                    @if($coupon->type == 'percent')
                        {{ $coupon->value }}%
                    @else
                        {{ number_format($coupon->value) }}đ
                    @endif
                </td>
                <td style="padding: 12px;">{{ number_format($coupon->min_order_value) }}đ</td>
                <td style="padding: 12px;">
                    {{ $coupon->used_count }} / {{ $coupon->usage_limit ? $coupon->usage_limit : 'Vô hạn' }}
                </td>
                <td style="padding: 12px;">
                    {{ $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('d/m/Y') : 'Không bao giờ' }}
                </td>
                <td style="padding: 12px; display: flex; gap: 5px;">
                    <a href="{{ route('admin.coupons.edit', $coupon->id) }}" style="background: #2196F3; color: white; text-decoration: none; padding: 5px 10px; border-radius: 4px; display: inline-block;"><i class="fa-solid fa-pen"></i></a>
                    <form action="{{ route('admin.coupons.delete', $coupon->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa mã giảm giá này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: #e74c3c; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
</div>
@endsection
