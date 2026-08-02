@extends('layouts.app')

@section('content')
<div class="modal" id="register-modal" style="display: flex;">
    <div class="modal__overlay" style="position: relative;"></div>
    <div class="modal__body" style="position: relative; margin: auto; margin-top: 50px; z-index: 2;">
        <div class="auth-form">
            <div class="auth-form__container">
                <div class="auth-form__hearder">
                    <h3 class="auth-form__heading">Đăng ký</h3>
                    <a href="{{ route('login') }}" class="auth-form__swicth-btn" style="text-decoration: none;">Đăng nhập</a>
                </div>

                @if($errors->any())
                    <div style="color: red; text-align: center; margin: 10px 0; font-size: 1.3rem;">
                        @foreach($errors->all() as $err)
                            {{ $err }}<br>
                        @endforeach
                    </div>
                    <script>
                        alert("Lỗi đăng ký:\n{{ $errors->first() }}");
                    </script>
                @endif

                <form action="{{ route('register') }}" method="POST" class="auth-form__form">
                    @csrf
                    <div class="auth-form__group">
                        <input type="text" name="name" value="{{ old('name') }}" class="auth-form__input" placeholder="Nhập tên người dùng" required>
                    </div>
                    <div class="auth-form__group">
                        <input type="email" name="email" value="{{ old('email') }}" class="auth-form__input" placeholder="Nhập email" required>
                    </div>
                    <div class="auth-form__group">
                        <input type="password" name="password" class="auth-form__input" placeholder="Nhập mật khẩu" required>
                    </div>
                    <div class="auth-form__group">
                        <input type="password" name="password_confirmation" class="auth-form__input" placeholder="Nhập lại mật khẩu" required>
                    </div>
                    <div class="auth-form__group">
                        <input type="text" name="phone" value="{{ old('phone') }}" class="auth-form__input" placeholder="Số điện thoại">
                    </div>
                    <div class="auth-form__group">
                        <input type="text" name="address" value="{{ old('address') }}" class="auth-form__input" placeholder="Địa chỉ giao hàng">
                    </div>

                    <div class="auth-form__aside" style="margin-top: 15px;">
                        <p class="auth-form__policy-text">
                            Bằng việc đăng kí, bạn đã đồng ý với shop về
                            <a href="#" class="auth-form__text-link">điều khoản dịch vụ</a> &
                            <a href="#" class="auth-form__text-link">chính sách bảo mật</a>
                        </p>
                    </div>

                    <div class="auth-form__controls" style="margin-top: 20px;">
                        <a href="{{ route('home') }}" class="btn auth-form__control-back btn--normal" style="text-decoration: none; line-height: 34px; text-align: center;">TRỞ LẠI</a>
                        <button type="submit" class="btn btn--primary">ĐĂNG KÝ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
