@extends('layouts.app')

@section('content')
<div class="grid">
    <div class="grid__row app__content">
        <!-- Sidebar Danh mục -->
        <div class="grid__column-2">
            <nav class="category">
                <h3 class="category__heading">Danh mục</h3>
                <ul class="category-list">
                    @foreach($categories as $category)
                        <li class="category-item {{ request('category') == $category->id ? 'category-item--active' : '' }}">
                            <a href="{{ route('home', array_merge(request()->query(), ['category' => $category->id, 'page' => 1])) }}" class="category-item__link">
                                {{ $category->category_name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>

        <!-- Vùng hiển thị sản phẩm -->
        <div class="grid__column-10">
            <!-- Filter & Phân trang -->
            <div class="home-filter">
                <span class="home-filter__label">Sắp xếp theo</span>
                <a href="{{ route('home', array_merge(request()->query(), ['sort' => ''])) }}" class="home-filter__btn btn {{ !request('sort') || request('sort') == 'random' ? 'btn--primary' : '' }}">Phổ biến</a>
                <a href="{{ route('home', array_merge(request()->query(), ['sort' => 'newest'])) }}" class="home-filter__btn btn {{ request('sort') == 'newest' ? 'btn--primary' : '' }}">Mới nhất</a>
                
                <div class="select-input">
                    <span class="select-input__label">Giá</span>
                    <i class="select-input__icon fas fa-angle-down"></i>
                    <ul class="select-input__list">
                        <li class="select-input__item">
                            <a href="{{ route('home', array_merge(request()->query(), ['sort' => 'price_asc'])) }}" class="select-input__link"> Giá: Thấp đến cao</a>
                        </li>
                        <li class="select-input__item">
                            <a href="{{ route('home', array_merge(request()->query(), ['sort' => 'price_desc'])) }}" class="select-input__link">Giá: Cao đến thấp</a>
                        </li>
                    </ul>
                </div>
                
                <div class="home-filter__page">
                    <span class="home-filter__page-num">
                        <span class="home-filter__page-current">{{ $products->currentPage() }}</span>/{{ $products->lastPage() }}
                    </span>
                    <div class="home-filter__page-control">
                        <!-- Nút Previous -->
                        @if($products->onFirstPage())
                            <a href="#" class="home-filter__page-btn home-filter__page-btn--disabled">
                                <i class="home-filter__page-icon fas fa-angle-left"></i>
                            </a>
                        @else
                            <a href="{{ $products->previousPageUrl() }}" class="home-filter__page-btn">
                                <i class="home-filter__page-icon fas fa-angle-left"></i>
                            </a>
                        @endif

                        <!-- Nút Next -->
                        @if($products->hasMorePages())
                            <a href="{{ $products->nextPageUrl() }}" class="home-filter__page-btn">
                                <i class="home-filter__page-icon fas fa-angle-right"></i>
                            </a>
                        @else
                            <a href="#" class="home-filter__page-btn home-filter__page-btn--disabled">
                                <i class="home-filter__page-icon fas fa-angle-right"></i>
                            </a>
                        @endif
                    </div>  
                </div>
            </div>
            
            <!-- Danh sách sản phẩm -->
            <div class="grid__row">
                @forelse($products as $p)
                    <div class="grid__column-2-4">
                        <a href="{{ route('product.detail', $p->id) }}" class="home-produc-item">
                            <div class="home-product-item__img">
                                <!-- Chú ý: path ảnh cũ có /uploads/ nên chỉ cần gọi asset() -->
                                <img src="{{ asset($p->image) }}" alt="{{ $p->name }}" style="width:100%; object-fit: cover;">
                            </div>
                            <h4 class="home-product-item__name">
                                {{ $p->name }}
                            </h4>

                            <div class="home-product-item__price">
                                @if($p->old_price > 0)
                                    <span class="home-product-item__price-old">
                                        {{ number_format($p->old_price, 0, ',', '.') }}đ
                                    </span>
                                @endif
                                <span class="home-product-item__price-current">
                                    {{ number_format($p->price, 0, ',', '.') }}đ
                                </span>
                            </div>

                            <div class="home-produc-item__action">
                                <span class="home-produc-item__like">
                                    <i class="home-produc-item__like-icon-empty fa-regular fa-heart"></i>
                                    <i class="home-produc-item__like-icon-fill fa-solid fa-heart"></i>
                                </span>
                                <span class="home-produc-item__sold">Còn {{ $p->quantity }}</span>
                            </div>

                            <div class="home-produc-item__origin">
                                <span class="home-produc-item__brand">{{ $p->brand }}</span>
                                <span class="home-produc-item__origin-name">{{ $p->category->category_name ?? '' }}</span>
                            </div>

                            @if($p->discount > 0)
                                <div class="home-produc-item__sale-off">
                                    <span class="home-produc-item__sale-off-percent">{{ $p->discount }}%</span>
                                    <span class="home-produc-item__sale-off-label">GIẢM</span>
                                </div>
                            @endif
                        </a>
                    </div>  
                @empty
                    <div class="grid__column-10" style="text-align: center; padding: 50px 0;">
                        <h3>Không tìm thấy sản phẩm nào phù hợp!</h3>
                    </div>
                @endforelse
            </div> 
            
            <!-- Phân trang Bootstrap / Custom -->
            <div style="margin-top: 20px;">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
