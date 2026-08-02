<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Ping Pong Store</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; margin: 0; background-color: #f4f6f9; color: #333; }
        * { box-sizing: border-box; }
        .admin-wrapper { display: flex; min-height: 100vh; }
        
        /* Sidebar */
        .admin-sidebar { width: 250px; background-color: #343a40; color: #fff; flex-shrink: 0; }
        .admin-sidebar__header { padding: 20px; text-align: center; border-bottom: 1px solid #4b545c; font-size: 20px; font-weight: bold; }
        .admin-menu { list-style: none; padding: 0; margin: 0; }
        .admin-menu__item { border-bottom: 1px solid #4b545c; }
        .admin-menu__link { display: block; padding: 15px 20px; color: #c2c7d0; text-decoration: none; transition: 0.3s; font-size: 15px; }
        .admin-menu__link:hover, .admin-menu__link--active { background-color: #495057; color: #fff; }
        .admin-menu__icon { margin-right: 10px; width: 20px; text-align: center; }

        /* Main Content */
        .admin-main { flex-grow: 1; display: flex; flex-direction: column; }
        
        /* Navbar */
        .admin-navbar { background-color: #fff; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .admin-navbar__title { margin: 0; font-size: 18px; font-weight: 500; }
        .admin-navbar__user { display: flex; align-items: center; gap: 15px; font-size: 15px; }
        .admin-navbar__logout { color: #e74c3c; text-decoration: none; font-weight: 500; }
        
        /* Content Area */
        .admin-content { padding: 20px; flex-grow: 1; }
        
        /* Grid system for dashboard */
        .row { display: flex; flex-wrap: wrap; margin: -10px; }
        .col-3 { width: 25%; padding: 10px; }
        .col-12 { width: 100%; padding: 10px; }
        
        @media (max-width: 992px) {
            .col-3 { width: 50%; }
        }
        @media (max-width: 768px) {
            .col-3 { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <aside class="admin-sidebar">
            <div class="admin-sidebar__header">
                <i class="fa-solid fa-table-tennis-paddle-ball"></i> PING PONG
            </div>
            <ul class="admin-menu">
                <li class="admin-menu__item">
                    <a href="{{ route('admin.dashboard') }}" class="admin-menu__link {{ request()->routeIs('admin.dashboard') ? 'admin-menu__link--active' : '' }}">
                        <i class="fa-solid fa-gauge admin-menu__icon"></i> Tổng quan
                    </a>
                </li>
                <li class="admin-menu__item">
                    <a href="{{ route('admin.products') }}" class="admin-menu__link {{ request()->routeIs('admin.products') ? 'admin-menu__link--active' : '' }}">
                        <i class="fa-solid fa-box admin-menu__icon"></i> Sản phẩm
                    </a>
                </li>
                <li class="admin-menu__item">
                    <a href="{{ route('admin.orders') }}" class="admin-menu__link {{ request()->routeIs('admin.orders') ? 'admin-menu__link--active' : '' }}">
                        <i class="fa-solid fa-cart-shopping admin-menu__icon"></i> Đơn hàng
                    </a>
                </li>
                <li class="admin-menu__item">
                    <a href="{{ route('admin.users') }}" class="admin-menu__link {{ request()->routeIs('admin.users') ? 'admin-menu__link--active' : '' }}">
                        <i class="fa-solid fa-users admin-menu__icon"></i> Người dùng
                    </a>
                </li>
                <li class="admin-menu__item">
                    <a href="{{ route('admin.categories') }}" style="display: block; padding: 15px 20px; color: #fff; text-decoration: none; border-bottom: 1px solid #3c4b5c; {{ request()->routeIs('admin.categories*') ? 'background: #3c4b5c; border-left: 4px solid #4CAF50;' : '' }}">
                        <i class="fa-solid fa-list" style="width: 25px;"></i> Danh mục
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reviews') }}" style="display: block; padding: 15px 20px; color: #fff; text-decoration: none; border-bottom: 1px solid #3c4b5c; {{ request()->routeIs('admin.reviews*') ? 'background: #3c4b5c; border-left: 4px solid #4CAF50;' : '' }}">
                        <i class="fa-solid fa-star" style="width: 25px;"></i> Đánh giá
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.coupons') }}" style="display: block; padding: 15px 20px; color: #fff; text-decoration: none; border-bottom: 1px solid #3c4b5c; {{ request()->routeIs('admin.coupons*') ? 'background: #3c4b5c; border-left: 4px solid #4CAF50;' : '' }}">
                        <i class="fa-solid fa-ticket" style="width: 25px;"></i> Mã giảm giá
                    </a>
                </li>
                <li class="admin-menu__item" style="margin-top: 20px; border-top: 2px solid #4b545c;">
                    <a href="{{ route('home') }}" class="admin-menu__link" target="_blank" style="color: #4CAF50;">
                        <i class="fa-solid fa-store admin-menu__icon"></i> Xem Cửa hàng
                    </a>
                </li>
            </ul>
        </aside>

        <main class="admin-main">
            <nav class="admin-navbar">
                <h2 class="admin-navbar__title">@yield('title', 'Dashboard')</h2>
                <div class="admin-navbar__user">
                    <span>Xin chào, <strong>{{ Auth::user()->name }}</strong></span>
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: #e74c3c; cursor: pointer; font-size: 15px; font-weight: 500;">
                            <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                        </button>
                    </form>
                </div>
            </nav>

            <div class="admin-content">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
