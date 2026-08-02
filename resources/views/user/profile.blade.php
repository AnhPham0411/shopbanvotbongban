@extends('layouts.app')

@section('content')
<div class="grid">
    <div class="grid__row" style="margin-top: 20px;">
        <!-- Sidebar -->
        <div class="grid__column-2">
            <div style="background-color: #fff; padding: 15px; border-radius: 2px; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.1);">
                <div style="display: flex; align-items: center; padding-bottom: 15px; border-bottom: 1px solid #efefef; margin-bottom: 15px;">
                    <img src="{{ asset('assets/img/iconuser.png') }}" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">
                    <div>
                        <div style="font-weight: 600; font-size: 1.4rem;">{{ Auth::user()->name }}</div>
                        <div style="color: #888; font-size: 1.2rem;"><i class="fas fa-pen"></i> Sửa hồ sơ</div>
                    </div>
                </div>
                <ul style="list-style: none; padding-left: 0; margin: 0; font-size: 1.4rem;">
                    <li style="margin-bottom: 15px;"><a href="{{ route('profile') }}" style="color: #ee4d2d; text-decoration: none;"><i class="fas fa-user" style="color: #1a94ff; width: 20px;"></i> Tài khoản của tôi</a></li>
                    <li style="margin-bottom: 15px;"><a href="{{ route('orders') }}" style="color: #333; text-decoration: none;"><i class="fas fa-clipboard-list" style="color: #1a94ff; width: 20px;"></i> Đơn mua</a></li>
                    <li><a href="{{ route('favorites') }}" style="color: #333; text-decoration: none;"><i class="fas fa-heart" style="color: #1a94ff; width: 20px;"></i> Yêu thích</a></li>
                </ul>
            </div>
        </div>

        <!-- Content -->
        <div class="grid__column-10">
            <div style="background-color: #fff; padding: 20px; border-radius: 2px; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.1);">
                <div style="border-bottom: 1px solid #efefef; padding-bottom: 15px; margin-bottom: 20px;">
                    <h2 style="font-size: 1.8rem; font-weight: 500; margin: 0; color: #333;">Hồ Sơ Của Tôi</h2>
                    <div style="font-size: 1.4rem; color: #555; margin-top: 5px;">Quản lý thông tin hồ sơ để bảo mật tài khoản</div>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" style="font-size: 1.4rem; color: #333; width: 80%;">
                    @csrf
                    
                    <div style="display: flex; margin-bottom: 20px; align-items: center;">
                        <div style="width: 20%; text-align: right; padding-right: 20px; color: #555;">Email đăng nhập</div>
                        <div style="width: 80%;">
                            <input type="text" value="{{ $user->email }}" disabled style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 2px; background-color: #f5f5f5;">
                        </div>
                    </div>

                    <div style="display: flex; margin-bottom: 20px; align-items: center;">
                        <div style="width: 20%; text-align: right; padding-right: 20px; color: #555;">Tên</div>
                        <div style="width: 80%;">
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 2px;">
                        </div>
                    </div>

                    <div style="display: flex; margin-bottom: 20px; align-items: center;">
                        <div style="width: 20%; text-align: right; padding-right: 20px; color: #555;">Số điện thoại</div>
                        <div style="width: 80%;">
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 2px;">
                        </div>
                    </div>

                    <div style="display: flex; margin-bottom: 20px; align-items: center;">
                        <div style="width: 20%; text-align: right; padding-right: 20px; color: #555;">Địa chỉ</div>
                        <div style="width: 80%;">
                            <input type="text" name="address" value="{{ old('address', $user->address) }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 2px;">
                        </div>
                    </div>

                    <div style="display: flex; margin-bottom: 20px;">
                        <div style="width: 20%;"></div>
                        <div style="width: 80%;">
                            <button type="submit" class="btn btn--primary" style="padding: 0 20px;">Lưu Thay Đổi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
