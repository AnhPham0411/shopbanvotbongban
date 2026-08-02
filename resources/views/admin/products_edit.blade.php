@extends('admin.layouts.admin_app')

@section('title', 'Sửa Sản phẩm')

@section('content')
<div style="background: #fff; padding: 25px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); max-width: 800px; margin: 0 auto;">
    <h3 style="margin-top: 0; margin-bottom: 20px;">Cập nhật Sản phẩm</h3>
    
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Tên sản phẩm *</label>
            <input type="text" name="name" value="{{ $product->name }}" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Danh mục *</label>
            <select name="category_id" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Giá (VNĐ) *</label>
            <input type="number" name="price" value="{{ $product->price }}" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Giá cũ (VNĐ)</label>
            <input type="number" name="old_price" value="{{ $product->old_price }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Thương hiệu</label>
            <input type="text" name="brand" value="{{ $product->brand }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Số lượng</label>
            <input type="number" name="quantity" value="{{ $product->quantity }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Hình ảnh hiện tại</label>
            @if($product->image)
                <img src="{{ asset(str_starts_with($product->image, 'uploads/') ? $product->image : 'uploads/' . $product->image) }}" alt="Ảnh" style="width: 100px; border-radius: 4px; display: block; margin-bottom: 10px;">
            @endif
            <input type="file" name="image" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Mô tả</label>
            <textarea name="description" rows="5" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">{{ $product->description }}</textarea>
        </div>
        
        <div style="margin-top: 20px;">
            <button type="submit" style="background: #4CAF50; color: #fff; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-size: 16px;">
                <i class="fa-solid fa-save"></i> Cập nhật
            </button>
            <a href="{{ route('admin.products') }}" style="display: inline-block; background: #6c757d; color: #fff; padding: 10px 20px; border-radius: 4px; text-decoration: none; margin-left: 10px; font-size: 16px;">Hủy</a>
        </div>
    </form>
</div>
@endsection
