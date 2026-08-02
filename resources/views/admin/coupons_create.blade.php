@extends('admin.layouts.admin_app')

@section('title', 'Thêm Mã giảm giá')

@section('content')
<div style="background: #fff; padding: 25px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); max-width: 600px; margin: 0 auto;">
    <h3 style="margin-top: 0; margin-bottom: 20px;">Thêm Mã giảm giá mới</h3>
    
    @if ($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #f5c6cb;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.coupons.store') }}" method="POST">
        @csrf
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Mã CODE * (VD: SALE20K)</label>
            <input type="text" name="code" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; text-transform: uppercase;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Loại giảm giá *</label>
            <select name="type" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                <option value="fixed">Giảm số tiền cố định (VNĐ)</option>
                <option value="percent">Giảm theo phần trăm (%)</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Giá trị giảm *</label>
            <input type="number" name="value" required min="1" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Đơn hàng tối thiểu (VNĐ) *</label>
            <input type="number" name="min_order_value" value="0" required min="0" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Giới hạn lượt dùng (Để trống nếu vô hạn)</label>
            <input type="number" name="usage_limit" min="1" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Ngày hết hạn (Để trống nếu không bao giờ hết hạn)</label>
            <input type="date" name="expires_at" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        
        <div style="margin-top: 20px;">
            <button type="submit" style="background: #4CAF50; color: #fff; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-size: 16px;">
                <i class="fa-solid fa-save"></i> Lưu mã giảm giá
            </button>
            <a href="{{ route('admin.coupons') }}" style="display: inline-block; background: #6c757d; color: #fff; padding: 10px 20px; border-radius: 4px; text-decoration: none; margin-left: 10px; font-size: 16px;">Hủy</a>
        </div>
    </form>
</div>
@endsection
