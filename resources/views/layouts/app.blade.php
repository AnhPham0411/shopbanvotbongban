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
    <style>
        /* Dark Mode Core Variables */
        body.dark-mode {
            --white-color: #1a1a1a;
            --text-color: #e0e0e0;
            --border-color: #333;
            background-color: #121212 !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .app__container,
        body.dark-mode .cart {
            background-color: #121212 !important;
        }

        /* Header Adjustments */
        body.dark-mode .header {
            background-image: linear-gradient(0, #1a1a1a, #2c2c2c) !important;
        }
        body.dark-mode .header__search-input,
        body.dark-mode .header__search-history,
        body.dark-mode .header__search-option-item,
        body.dark-mode .header__cart-list,
        body.dark-mode .header__notify,
        body.dark-mode .header__notify-header,
        body.dark-mode .header__navbar-user-menu,
        body.dark-mode .auth-form {
            background-color: #1f1f1f !important;
            color: #e0e0e0 !important;
            border-color: #333 !important;
        }

        /* Fix missing white texts in header */
        body.dark-mode .header__navbar-item,
        body.dark-mode .header__navbar-item-link,
        body.dark-mode .header__navbar-icon-link,
        body.dark-mode .header__cart-icon,
        body.dark-mode .header__search-btn-icon,
        body.dark-mode .header__navbar-title--no-poiter,
        body.dark-mode .header__search-select-label,
        body.dark-mode .header__search-select-icon {
            color: #e0e0e0 !important;
        }

        /* Links & Text */
        body.dark-mode .header__navbar-user-item a,
        body.dark-mode .header__notify-name,
        body.dark-mode .header__cart-item-name,
        body.dark-mode .header__search-history-item a,
        body.dark-mode .category-item__link,
        body.dark-mode .category__heading,
        body.dark-mode .home-product-item__name,
        body.dark-mode .footer-link,
        body.dark-mode .footer__heading,
        body.dark-mode .product-name,
        body.dark-mode .related-product-item a,
        body.dark-mode .cart-info h3,
        body.dark-mode .cart-table th,
        body.dark-mode .home-produc-item__origin-name,
        body.dark-mode .product-info p,
        body.dark-mode .quantity__label,
        body.dark-mode .home-filter__label,
        body.dark-mode .select-input__label,
        body.dark-mode .select-input__link,
        body.dark-mode .pagination-item__link,
        body.dark-mode .auth-form__heading,
        body.dark-mode .header__cart-heading,
        body.dark-mode .home-filter__page-icon,
        body.dark-mode .product-description h2,
        body.dark-mode .description-content {
            color: #e0e0e0 !important;
        }

        /* Secondary/muted text */
        body.dark-mode .home-produc-item__origin,
        body.dark-mode .home-produc-item__sold,
        body.dark-mode .home-product-item__price-old,
        body.dark-mode .header__cart-item-qnt,
        body.dark-mode .header__cart-item-multiply,
        body.dark-mode .header__cart-list--no-cart-msg,
        body.dark-mode .header__notify-descrition,
        body.dark-mode .home-produc-item__like-icon-empty {
            color: #aaa !important;
        }

        body.dark-mode .home-filter__page-btn--disabled .home-filter__page-icon {
            color: #777 !important;
        }

        /* Specific Backgrounds */
        body.dark-mode .home-produc-item,
        body.dark-mode .category,
        body.dark-mode .product-detail,
        body.dark-mode .related-products,
        body.dark-mode .product-description,
        body.dark-mode .cart-table,
        body.dark-mode .home-product-item__img,
        body.dark-mode .quantity__box input,
        body.dark-mode .quantity__btn,
        body.dark-mode .select-input,
        body.dark-mode .select-input__list,
        body.dark-mode .pagination-item__link,
        body.dark-mode .home-filter__page-btn,
        body.dark-mode .auth-form__input,
        body.dark-mode .header__search-input {
            background-color: #1f1f1f !important;
            border-color: #333 !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .product-description div[style*="background: #f9f9f9"],
        body.dark-mode .product-description div[style*="background: #fff"] {
            background-color: #2c2c2c !important;
            color: #e0e0e0 !important;
            border-color: #333 !important;
        }

        body.dark-mode .cart-table thead,
        body.dark-mode .product-price,
        body.dark-mode .auth-form__socials,
        body.dark-mode .quantity__btn:disabled,
        body.dark-mode .home-filter,
        body.dark-mode .home-filter__page-btn--disabled {
            background-color: #2c2c2c !important;
        }
        
        body.dark-mode .quantity__btn:disabled {
            color: #777 !important;
        }

        /* Borders */
        body.dark-mode .cart-table th,
        body.dark-mode .cart-table td,
        body.dark-mode .header__cart-item,
        body.dark-mode .category-item::before,
        body.dark-mode .cart-table,
        body.dark-mode .quantity__box,
        body.dark-mode .quantity__box input,
        body.dark-mode .auth-form__input,
        body.dark-mode .header__search-select,
        body.dark-mode .home-filter__page-btn:first-child {
            border-color: #333 !important;
        }

        body.dark-mode .header__navbar-user-menu::before,
        body.dark-mode .header__notify::after,
        body.dark-mode .header__cart-list::after {
            border-color: transparent transparent #1f1f1f transparent !important;
        }

        /* Hovers */
        body.dark-mode .header__navbar-user-item a:hover,
        body.dark-mode .header__notify-item:hover,
        body.dark-mode .header__cart-item:hover,
        body.dark-mode .header__search-history-item:hover,
        body.dark-mode .header__search-option-item:hover,
        body.dark-mode .cart-table tr:hover,
        body.dark-mode .category-item__link:hover,
        body.dark-mode .quantity__btn:hover:not(:disabled),
        body.dark-mode .select-input__link:hover {
            background-color: #333 !important;
        }
        
        body.dark-mode .select-input__link:hover {
            color: var(--primary-color) !important;
        }

        body.dark-mode .footer__bottom {
            background-color: #1f1f1f !important;
        }
    </style>
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
                            <a href="#" onclick="return false;" class="header__navbar-item-link">
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
                            <a href="{{ route('help_center') }}" class="header__navbar-item-link">
                                <i class="header__navbar-icon fa-regular fa-circle-question"></i>
                                Trợ giúp
                            </a>
                        </li>
                        <li class="header__navbar-item">
                            <a href="#" id="theme-toggle" class="header__navbar-item-link" onclick="return false;">
                                <i id="theme-icon" class="header__navbar-icon fa-solid fa-moon"></i>
                                <span id="theme-text">Chế độ tối</span>
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
                            <li class="footer-item"><a href="{{ route('help_center') }}" class="footer-link">Trung tâm trợ giúp</a></li>
                            <li class="footer-item"><a href="{{ route('shopping_guide') }}" class="footer-link">Hướng dẫn mua hàng</a></li>
                            <li class="footer-item"><a href="{{ route('auth_guide') }}" class="footer-link">Hướng dẫn đăng kí đăng nhập</a></li>
                        </ul>
                    </div>
                    <div class="grid__column-2-4">
                        <h3 class="footer__heading">Giới thiệu</h3>
                        <ul class="footer__list">
                            <li class="footer-item"><a href="{{ route('about') }}" class="footer-link">Giới thiệu</a></li>
                            <li class="footer-item"><a href="{{ route('careers') }}" class="footer-link">Tuyển dụng</a></li>
                            <li class="footer-item"><a href="{{ route('terms') }}" class="footer-link">Điều khoản</a></li>
                        </ul>
                    </div>
                    <div class="grid__column-2-4">
                        <h3 class="footer__heading">Danh mục</h3>
                        <ul class="footer__list">
                            <li class="footer-item"><a href="{{ route('home', ['keyword' => 'cốt']) }}" class="footer-link">Cốt vợt</a></li>
                            <li class="footer-item"><a href="{{ route('home', ['keyword' => 'mặt']) }}" class="footer-link">Mặt vợt</a></li>
                            <li class="footer-item"><a href="{{ route('home', ['keyword' => 'bóng']) }}" class="footer-link">Bóng bàn</a></li>
                        </ul>
                    </div>
                    <div class="grid__column-2-4">
                        <h3 class="footer__heading">Theo dõi</h3>
                        <ul class="footer__list">
                            <li class="footer-item"><a href="#" onclick="return false;" class="footer-link"><i class="footer-icon fa-brands fa-facebook"></i> Facebook</a></li>
                            <li class="footer-item"><a href="#" onclick="return false;" class="footer-link"><i class="footer-icon fa-brands fa-instagram"></i> Instagram</a></li>
                            <li class="footer-item"><a href="#" onclick="return false;" class="footer-link"><i class="footer-icon fa-brands fa-linkedin-in"></i> Linkedin</a></li>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('theme-toggle');
            const themeIcon = document.getElementById('theme-icon');
            const themeText = document.getElementById('theme-text');
            
            // Check for saved theme
            const currentTheme = localStorage.getItem('theme');
            if (currentTheme === 'dark') {
                document.body.classList.add('dark-mode');
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
                themeText.innerText = 'Chế độ sáng';
            }
    
            if (themeToggle) {
                themeToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.body.classList.toggle('dark-mode');
                    let theme = 'light';
                    
                    if (document.body.classList.contains('dark-mode')) {
                        theme = 'dark';
                        themeIcon.classList.remove('fa-moon');
                        themeIcon.classList.add('fa-sun');
                        themeText.innerText = 'Chế độ sáng';
                    } else {
                        themeIcon.classList.remove('fa-sun');
                        themeIcon.classList.add('fa-moon');
                        themeText.innerText = 'Chế độ tối';
                    }
                    
                    localStorage.setItem('theme', theme);
                });
            }
        });
    </script>
</body>
</html>
