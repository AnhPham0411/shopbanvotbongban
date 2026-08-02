@extends('admin.layouts.admin_app')

@section('title', 'Sửa Mã giảm giá')

@section('content')
<div style="background: #fff; padding: 25px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); max-width: 600px; margin: 0 auto;">
    <h3 style="margin-top: 0; margin-bottom: 20px;">Sửa Mã giảm giá</h3>
    
    @if ($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #f5c6cb;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Mã CODE *</label>
            <input type="text" name="code" value="{{ $coupon->code }}" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; text-transform: uppercase;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Loại giảm giá *</label>
            <select name="type" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                <option value="fixed" {{ $coupon->type == 'fixed' ? 'selected' : '' }}>Giảm số tiền cố định (VNĐ)</option>
                <option value="percent" {{ $coupon->type == 'percent' ? 'selected' : '' }}>Giảm theo phần trăm (%)</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Giá trị giảm *</label>
            <input type="number" name="value" value="{{ $coupon->value }}" required min="1" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Đơn hàng tối thiểu (VNĐ) *</label>
            <input type="number" name="min_order_value" value="{{ $coupon->min_order_value }}" required min="0" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Giới hạn lượt dùng (Để trống nếu vô hạn)</label>
            <input type="number" name="usage_limit" value="{{ $coupon->usage_limit }}" min="1" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Ngày hết hạn (Để trống nếu không bao giờ hết hạn)</label>
            <input type="date" name="expires_at" value="{{ $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('Y-m-d') : '' }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        
        <div style="margin-top: 20px;">
            <button type="submit" style="background: #4CAF50; color: #fff; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-size: 16px;">
                <i class="fa-solid fa-save"></i> Cập nhật
            </button>
            <a href="{{ route('admin.coupons') }}" style="display: inline-block; background: #6c757d; color: #fff; padding: 10px 20px; border-radius: 4px; text-decoration: none; margin-left: 10px; font-size: 16px;">Hủy</a>
        </div>
    </form>
</div>
@endsection
