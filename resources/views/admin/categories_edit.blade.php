@extends('admin.layouts.admin_app')

@section('title', 'Sửa Danh mục')

@section('content')
<div style="background: #fff; padding: 25px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); max-width: 600px; margin: 0 auto;">
    <h3 style="margin-top: 0; margin-bottom: 20px;">Cập nhật Danh mục</h3>
    
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Tên danh mục *</label>
            <input type="text" name="category_name" value="{{ $category->category_name }}" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        
        <div style="margin-top: 20px;">
            <button type="submit" style="background: #4CAF50; color: #fff; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-size: 16px;">
                <i class="fa-solid fa-save"></i> Cập nhật
            </button>
            <a href="{{ route('admin.categories') }}" style="display: inline-block; background: #6c757d; color: #fff; padding: 10px 20px; border-radius: 4px; text-decoration: none; margin-left: 10px; font-size: 16px;">Hủy</a>
        </div>
    </form>
</div>
@endsection
