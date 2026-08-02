@extends('admin.layouts.admin_app')

@section('title', 'Quản lý Người dùng')

@section('content')
<div style="background: #fff; padding: 25px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <h3 style="margin-top: 0; margin-bottom: 20px;">Danh sách Người dùng</h3>
    
    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
        <thead>
            <tr style="border-bottom: 2px solid #eee; background: #f9f9f9;">
                <th style="padding: 12px;">ID</th>
                <th style="padding: 12px;">Tên</th>
                <th style="padding: 12px;">Email</th>
                <th style="padding: 12px;">Vai trò</th>
                <th style="padding: 12px;">Ngày tham gia</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 12px;">#{{ $user->id }}</td>
                <td style="padding: 12px; font-weight: 500;">{{ $user->name }}</td>
                <td style="padding: 12px;">{{ $user->email }}</td>
                <td style="padding: 12px;">
                    @if($user->role == 'admin')
                        <span style="padding: 4px 8px; border-radius: 4px; background: #dc3545; color: white; font-size: 12px;">Admin</span>
                    @else
                        <span style="padding: 4px 8px; border-radius: 4px; background: #6c757d; color: white; font-size: 12px;">User</span>
                    @endif
                </td>
                <td style="padding: 12px;">{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    

</div>
@endsection
