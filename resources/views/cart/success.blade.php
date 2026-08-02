@extends('layouts.app')

@section('content')
<div class="grid" style="margin-top: 20px; padding: 50px 20px; background: #fff; border-radius: 4px; text-align: center;">
    <i class="fa-solid fa-circle-check" style="font-size: 80px; color: #4CAF50; margin-bottom: 20px;"></i>
    <h2 style="margin-bottom: 15px; font-size: 28px; color: #333;">Đặt hàng thành công!</h2>
    <p style="color: #666; margin-bottom: 30px; font-size: 16px;">Cảm ơn bạn đã mua sắm tại Shop Bóng Bàn. Đơn hàng của bạn đang được xử lý.</p>
    
    <a href="{{ route('home') }}" class="btn btn--primary" style="padding: 0 30px;">Tiếp tục mua sắm</a>
</div>
@endsection
