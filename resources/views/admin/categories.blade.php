@extends('admin.layouts.admin_app')

@section('title', 'Quản lý Danh mục')

@section('content')
<div style="background: #fff; padding: 25px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3 style="margin: 0;">Danh sách Danh mục</h3>
        <a href="{{ route('admin.categories.create') }}" style="background: #4CAF50; color: #fff; text-decoration: none; padding: 10px 15px; border-radius: 4px; display: inline-block;">
            <i class="fa-solid fa-plus"></i> Thêm mới
        </a>
    </div>
    
    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
        <thead>
            <tr style="border-bottom: 2px solid #eee; background: #f9f9f9;">
                <th style="padding: 12px;">ID</th>
                <th style="padding: 12px;">Tên danh mục</th>
                <th style="padding: 12px;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 12px;">#{{ $category->id }}</td>
                <td style="padding: 12px; font-weight: 500;">{{ $category->category_name }}</td>
                <td style="padding: 12px; display: flex; gap: 5px;">
                    <a href="{{ route('admin.categories.edit', $category->id) }}" style="background: #2196F3; color: white; text-decoration: none; padding: 5px 10px; border-radius: 4px; display: inline-block;"><i class="fa-solid fa-pen"></i></a>
                    <form action="{{ route('admin.categories.delete', $category->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
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
