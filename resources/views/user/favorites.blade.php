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
                    <li style="margin-bottom: 15px;"><a href="{{ route('profile') }}" style="color: #333; text-decoration: none;"><i class="fas fa-user" style="color: #1a94ff; width: 20px;"></i> Tài khoản của tôi</a></li>
                    <li style="margin-bottom: 15px;"><a href="{{ route('addresses.index') }}" style="color: #333; text-decoration: none;"><i class="fas fa-map-marker-alt" style="color: #1a94ff; width: 20px;"></i> Sổ địa chỉ</a></li>
                    <li style="margin-bottom: 15px;"><a href="{{ route('orders') }}" style="color: #333; text-decoration: none;"><i class="fas fa-clipboard-list" style="color: #1a94ff; width: 20px;"></i> Đơn mua</a></li>
                    <li><a href="{{ route('favorites') }}" style="color: #ee4d2d; text-decoration: none;"><i class="fas fa-heart" style="color: #1a94ff; width: 20px;"></i> Yêu thích</a></li>
                </ul>
            </div>
        </div>

        <!-- Content -->
        <div class="grid__column-10">
            <div style="background-color: #fff; padding: 20px; border-radius: 2px; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.1);">
                <div style="border-bottom: 1px solid #efefef; padding-bottom: 15px; margin-bottom: 20px;">
                    <h2 style="font-size: 1.8rem; font-weight: 500; margin: 0; color: #333;">Sản Phẩm Yêu Thích</h2>
                    <div style="font-size: 1.4rem; color: #555; margin-top: 5px;">Quản lý những sản phẩm bạn đã thêm vào mục yêu thích</div>
                </div>

                @if(session('success'))
                <div style="padding: 10px; margin-bottom: 15px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; font-size: 1.4rem;">
                    {{ session('success') }}
                </div>
                @endif

                @if($favorites->count() == 0)
                    <div style="text-align: center; padding: 50px 0; font-size: 1.6rem; color: #777;">
                        <i class="fas fa-heart-broken" style="font-size: 5rem; color: #ccc; margin-bottom: 15px; display: block;"></i>
                        Bạn chưa có sản phẩm yêu thích nào.
                    </div>
                @else
                    <div class="grid__row">
                    @foreach($favorites as $fav)
                        @php
                            $row = $fav->product;
                        @endphp
                        <div class="grid__column-2-4">
                            <!-- home-product-item -->
                            <a class="home-product-item" href="{{ route('product.detail', $row->id) }}" style="display: block; text-decoration: none; border: 1px solid #eee; border-radius: 2px; overflow: hidden; margin-bottom: 10px;">
                                @php
                                    $img = $row->image;
                                    if(!str_starts_with($img, 'uploads/') && !str_starts_with($img, 'assets/')) {
                                        $img = 'uploads/' . $img;
                                    }
                                @endphp
                                <div class="home-product-item__img" style="background-image: url('{{ asset($img) }}'); padding-top: 100%; background-size: cover; background-position: center;">
                                </div>
                                
                                <div style="padding: 10px;">
                                    <h4 class="home-product-item__name" style="font-size: 1.4rem; font-weight: 400; color: #333; line-height: 1.8rem; height: 3.6rem; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; margin: 0 0 5px;">
                                        {{ $row->name }}
                                    </h4>
                                    <div class="home-product-item__price" style="display: flex; align-items: baseline; flex-wrap: wrap;">
                                        <span class="home-product-item__price-current" style="font-size: 1.6rem; color: #ee4d2d;">
                                            {{ number_format($row->price, 0, ',', '.') }}đ
                                        </span>
                                    </div>
                                    <div class="home-product-item__action" style="display: flex; justify-content: space-between; margin-top: 10px; align-items: center;">
                                        <!-- Form to remove from favorite -->
                                        <form action="{{ route('favorites.toggle', $row->id) }}" method="POST" style="margin: 0; flex-grow: 1; text-align: center;">
                                            @csrf
                                            <button type="submit" style="background: none; border: 1px solid #ee4d2d; color: #ee4d2d; width: 100%; padding: 5px 0; border-radius: 2px; cursor: pointer; font-size: 1.2rem;">
                                                <i class="fas fa-heart"></i> Bỏ thích
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
