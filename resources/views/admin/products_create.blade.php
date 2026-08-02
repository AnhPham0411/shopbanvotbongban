@extends('admin.layouts.admin_app')

@section('title', 'Thêm Sản phẩm Mới')

@section('content')
<div style="background: #fff; padding: 25px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); max-width: 800px; margin: 0 auto;">
    <h3 style="margin-top: 0; margin-bottom: 20px;">Thêm Sản phẩm Mới</h3>
    
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Tên sản phẩm *</label>
            <input type="text" name="name" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Danh mục *</label>
            <select name="category_id" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Giá (VNĐ) *</label>
            <input type="number" name="price" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Giá cũ (VNĐ)</label>
            <input type="number" name="old_price" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Thương hiệu</label>
            <input type="text" name="brand" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Số lượng</label>
            <input type="number" name="quantity" value="10" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Hình ảnh</label>
            <input type="file" name="image" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Mô tả</label>
            <textarea name="description" rows="5" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;"></textarea>
        </div>
        
        <div style="margin-top: 20px;">
            <button type="submit" style="background: #4CAF50; color: #fff; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-size: 16px;">
                <i class="fa-solid fa-save"></i> Lưu sản phẩm
            </button>
            <a href="{{ route('admin.products') }}" style="display: inline-block; background: #6c757d; color: #fff; padding: 10px 20px; border-radius: 4px; text-decoration: none; margin-left: 10px; font-size: 16px;">Hủy</a>
        </div>
    </form>
</div>
@endsection
