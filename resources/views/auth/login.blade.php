@extends('layouts.app')

@section('content')
<div class="modal" id="login-modal" style="display: flex;">
    <div class="modal__overlay" style="position: relative;"></div>
    <div class="modal__body" style="position: relative; margin: auto; margin-top: 50px; z-index: 2;">
        <div class="auth-form">
            <div class="auth-form__container">
                <div class="auth-form__hearder">
                    <h3 class="auth-form__heading">Đăng nhập</h3>
                    <a href="{{ route('register') }}" class="auth-form__swicth-btn" style="text-decoration: none;">Đăng ký</a>
                </div>

                @if($errors->any())
                    <div style="color: red; text-align: center; margin: 10px 0; font-size: 1.3rem; font-weight: 500;">
                        @foreach($errors->all() as $err)
                            {{ $err }}<br>
                        @endforeach
                    </div>
                    <script>
                        alert("Lỗi đăng nhập:\n{{ $errors->first() }}");
                    </script>
                @endif

                <form action="{{ route('login') }}" method="POST" class="auth-form__form">
                    @csrf
                    <div class="auth-form__group">
                        <input type="email" name="email" value="{{ old('email') }}" class="auth-form__input" placeholder="Nhập email" required>
                    </div>
                    <div class="auth-form__group">
                        <input type="password" name="password" class="auth-form__input" placeholder="Nhập mật khẩu" required>
                    </div>
                    
                    <div class="auth-form__aside">
                        <div class="auth-form__help">
                            <a href="#" class="auth-form__help-link auth-form__help-forgot">Quên mật khẩu</a>
                            <span class="auth-form__help-separate"></span>
                            <a href="#" class="auth-form__help-link auth-form__help-link-help">Cần trợ giúp?</a>
                        </div>
                    </div>
                    
                    <div class="auth-form__controls">
                        <a href="{{ route('home') }}" class="btn btn--normal auth-form__control-back" style="text-decoration: none; line-height: 34px; text-align: center;">TRỞ LẠI</a>
                        <button type="submit" class="btn btn--primary">ĐĂNG NHẬP</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
