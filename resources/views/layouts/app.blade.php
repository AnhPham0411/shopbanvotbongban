<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Bóng Bàn</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome-free-6.6.0-web/css/all.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="app">
        <header class="header">
            <div class="grid">
                <nav class="header__navbar">   
                    <ul class="header__navbar-list">
                        <li class="header__navbar-item header__navbar-item--has-qr header__navbar-item--separate ">
                            Truy cập link shop
                            <div class="header__qr">
                                <img src="{{ asset('assets/img/Screenshot 2024-10-01 084821.png') }}" alt="" class="header__qr-img">
                                <div class="header__qr-apps">
                                    <a href="" class="header__qr-link">
                                        <img src="{{ asset('assets/img/1fddd5ee3e2ead84.png') }}" alt="Google Play" class="header__qr-download-img">
                                    </a>
                                    <a href="" class="header__qr-link">
                                        <img src="{{ asset('assets/img/135555214a82d8e1.png') }}" alt="Appstore" class="header__qr-download-img">
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li class="header__navbar-item">
                            <span class="header__navbar-title--no-poiter">Kết nối</span>
                            <a href="" class="header__navbar-icon-link"><i class="header__navbar-icon fa-brands fa-facebook"></i></a>
                            <a href="" class="header__navbar-icon-link"><i class="header__navbar-icon fa-brands fa-square-instagram"></i></a>
                        </li>
                    </ul>
    
                    <ul class="header__navbar-list">
                        <li class="header__navbar-item header__navbar-item--has-notify">
                            <a href="" class="header__navbar-item-link">
                                <i class="header__navbar-icon fa-regular fa-bell"></i>
                                Thông báo
                            </a>
                            <div class="header__notify">
                                <header class="header__notify-header">
                                    <h3>Thông báo mới nhận</h3>
                                </header>
                                <ul class="header__notify-list">
                                    <!-- Notifications list -->
                                    <li class="header__notify-item header__notify-item--viewed">
                                        <a href="" class="header__notify-link">
                                            <div class="header__notify-info">
                                                <span class="header__notify-name">Chào mừng bạn đến với Shop Bóng Bàn</span>
                                                <span class="header__notify-descrition">Cửa hàng dụng cụ bóng bàn hàng đầu</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                <footer class="header__notify-footer">
                                    <a href="" class="header__notify-footer-btn">Xem tất cả</a>
                                </footer>
                            </div>
                        </li>
                        <li class="header__navbar-item">
                            <a href="" class="header__navbar-item-link">
                                <i class="header__navbar-icon fa-regular fa-circle-question"></i>
                                Trợ giúp
                            </a>
                        </li>
                        
                        @guest
                            <li id="registerBtn" class="header__navbar-item header__navbar-item--strong header__navbar-item--separate">
                                <a href="{{ route('register') }}" style="color: inherit; text-decoration: none;">Đăng kí</a>
                            </li>
                            <li id="loginBtn" class="header__navbar-item header__navbar-item--strong">
                                <a href="{{ route('login') }}" style="color: inherit; text-decoration: none;">Đăng nhập</a>
                            </li>
                        @else
                            <li class="header__navbar-item header__navbar-user">
                                <img src="{{ asset('assets/img/iconuser.png') }}" alt="" class="header__navbar-user-img">
                                <span class="header__navbar-user-name">{{ Auth::user()->name }}</span>
                                <ul class="header__navbar-user-menu">
                                    <li class="header__navbar-user-item">
                                        <a href="{{ route('profile') }}">Tài Khoản của tôi</a>
                                    </li>
                                    <li class="header__navbar-user-item">
                                        <a href="{{ route('orders') }}">Đơn mua</a>
                                    </li>
                                    <li class="header__navbar-user-item">
                                        <a href="{{ route('favorites') }}">Yêu thích</a>
                                    </li>
                                    @if(Auth::user()->role === 'admin')
                                    <li class="header__navbar-user-item">
                                        <a href="{{ route('admin.dashboard') }}">Trang quản trị</a>
                                    </li>
                                    @endif
                                    <li class="header__navbar-user-item header__navbar-user-item--separate">
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng xuất</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </nav>
                
                <!-- Header with search -->
                <div class="header-with-search">
                    <div class="header__logo">
                        <a href="{{ route('home') }}" class="header__logo-link">
                            <img src="{{ asset('assets/img/logo.jpg') }}" alt="Logo" class="header__logo-img">
                        </a>
                    </div>
                    <div class="header__search">
                        <form action="{{ route('home') }}" method="GET" class="header__search-input-warp" style="display:flex;align-items:center;">
                            <input
                                type="text"
                                name="keyword"
                                class="header__search-input"
                                placeholder="Nhập để tìm kiếm sản phẩm..."
                                value="{{ request('keyword') }}">

                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif

                            <button type="submit" class="header__search-btn">
                                <i class="header__search-btn-icon fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>                
                    </div>
                    
                    @php
                        $cart = session('cart', []);
                        $cartCount = 0;
                        foreach($cart as $item) {
                            $cartCount += $item['quantity'];
                        }
                    @endphp

                    <!-- Cart layout -->
                    <div class="header__cart">
                        <div class="header__cart-wrap">
                            <a href="{{ route('cart.index') }}">
                                <i class="header__cart-icon fa-solid fa-cart-shopping"></i>
                                @if($cartCount > 0)
                                    <span class="header__cart-notice">{{ $cartCount }}</span>
                                @endif
                            </a>

                            <div class="header__cart-list {{ empty($cart) ? 'header__cart-list--no-cart' : '' }}">
                                @if(empty($cart))
                                    <img src="{{ asset('assets/img/empty-cart1690370236.png') }}" class="header__cart-no-cart-img">
                                    <span class="header__cart-list--no-cart-msg">Chưa có sản phẩm</span>
                                @else
                                    <h4 class="header__cart-heading">Sản phẩm mới thêm</h4>
                                    <ul class="header__cart-list-item">
                                        @php $count = 0; @endphp
                                        @foreach(array_reverse($cart) as $id => $item)
                                            @if($count == 3) @break @endif
                                            @php $count++; @endphp
                                            <li class="header__cart-item">
                                                <img src="{{ asset($item['image']) }}" class="header__cart-img">
                                                <div class="header__cart-item-info">
                                                    <h5 class="header__cart-item-name">{{ $item['name'] }}</h5>
                                                    <div class="header__cart-item-price-wrap">
                                                        <span class="header__cart-item-price">{{ number_format($item['price'], 0, ',', '.') }}đ</span>
                                                        <span class="header__cart-item-multiply">×</span>
                                                        <span class="header__cart-item-qnt">{{ $item['quantity'] }}</span>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="header__cart-footer">
                                        <a href="{{ route('cart.index') }}" class="btn btn--primary header__cart-view-cart">Xem giỏ hàng</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="app__container">
            @yield('content')
        </div>

        <footer class="footer"> 
            <div class="grid">
                <div class="grid__row">
                    <div class="grid__column-2-4">
                        <h3 class="footer__heading">Chăm sóc khách hàng</h3>
                        <ul class="footer__list">
                            <li class="footer-item"><a href="" class="footer-link">Trung tâm trợ giúp</a></li>
                            <li class="footer-item"><a href="" class="footer-link">Hướng dẫn mua hàng</a></li>
                            <li class="footer-item"><a href="" class="footer-link">Hướng dẫn đăng kí đăng nhập</a></li>
                        </ul>
                    </div>
                    <div class="grid__column-2-4">
                        <h3 class="footer__heading">Giới thiệu</h3>
                        <ul class="footer__list">
                            <li class="footer-item"><a href="" class="footer-link">Giới thiệu</a></li>
                            <li class="footer-item"><a href="" class="footer-link">Tuyển dụng</a></li>
                            <li class="footer-item"><a href="" class="footer-link">Điều khoản</a></li>
                        </ul>
                    </div>
                    <div class="grid__column-2-4">
                        <h3 class="footer__heading">Danh mục</h3>
                        <ul class="footer__list">
                            <li class="footer-item"><a href="" class="footer-link">Cốt vợt</a></li>
                            <li class="footer-item"><a href="" class="footer-link">Mặt vợt</a></li>
                            <li class="footer-item"><a href="" class="footer-link">Bóng bàn</a></li>
                        </ul>
                    </div>
                    <div class="grid__column-2-4">
                        <h3 class="footer__heading">Theo dõi</h3>
                        <ul class="footer__list">
                            <li class="footer-item"><a href="" class="footer-link"><i class="footer-icon fa-brands fa-facebook"></i> Facebook</a></li>
                            <li class="footer-item"><a href="" class="footer-link"><i class="footer-icon fa-brands fa-instagram"></i> Instagram</a></li>
                            <li class="footer-item"><a href="" class="footer-link"><i class="footer-icon fa-brands fa-linkedin-in"></i> Linkedin</a></li>
                        </ul>   
                    </div>
                    <div class="grid__column-2-4">
                        <h3 class="footer__heading">Vào cửa hàng trên ứng dụng</h3>
                        <div class="footer__dowload">
                            <img src="{{ asset('assets/img/Screenshot 2024-10-01 084821.png') }}" alt="Download QR" class="footer__dowload-qr">
                            <div class="footer__dowload-apps">
                                <a href="" class="footer__dowload-app-link">
                                    <img src="{{ asset('assets/img/135555214a82d8e1.png') }}" alt="Appstore" class="footer__dowload-app-img">
                                </a>
                                <a href="" class="footer__dowload-app-link">
                                    <img src="{{ asset('assets/img/1fddd5ee3e2ead84.png') }}" alt="Google Play" class="footer__dowload-app-img">
                                </a>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
            <div class="footer__bottom">
                <div class="grid">
                    <p class="footert__text">© {{ date('Y') }} - Bản quyền thuộc về MCU</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Hiển thị thông báo thành công hoặc lỗi -->
    @if(session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif

    @if(session('error'))
        <script>
            alert("{{ session('error') }}");
        </script>
    @endif
</body>
</html>
