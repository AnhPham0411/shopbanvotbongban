@extends('admin.layouts.admin_app')

@section('title', 'Quản lý Đánh giá')

@section('content')
<div style="background: #fff; padding: 25px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3 style="margin: 0;">Danh sách Đánh giá sản phẩm</h3>
    </div>
    
    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
        <thead>
            <tr style="background: #f4f6f9; border-bottom: 2px solid #ddd;">
                <th style="padding: 12px; width: 50px;">ID</th>
                <th style="padding: 12px;">Người dùng</th>
                <th style="padding: 12px;">Sản phẩm</th>
                <th style="padding: 12px;">Sao</th>
                <th style="padding: 12px;">Bình luận</th>
                <th style="padding: 12px;">Ngày tạo</th>
                <th style="padding: 12px;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reviews as $review)
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 12px;">#{{ $review->id }}</td>
                <td style="padding: 12px;">{{ optional($review->user)->name }}</td>
                <td style="padding: 12px; font-weight: 500;">
                    <a href="{{ route('product.detail', $review->product_id) }}" target="_blank" style="color: #2196F3; text-decoration: none;">
                        {{ optional($review->product)->name }}
                    </a>
                </td>
                <td style="padding: 12px; color: #ff9800; font-weight: bold;">
                    {{ $review->rating }} <i class="fa-solid fa-star"></i>
                </td>
                <td style="padding: 12px; max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $review->comment }}">
                    {{ $review->comment }}
                </td>
                <td style="padding: 12px;">{{ $review->created_at->format('d/m/Y H:i') }}</td>
                <td style="padding: 12px;">
                    <form action="{{ route('admin.reviews.delete', $review->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: #e74c3c; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;"><i class="fa-solid fa-trash"></i> Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
</div>
@endsection
