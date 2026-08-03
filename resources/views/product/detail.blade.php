@extends('layouts.app')

@section('content')
<div class="grid">
    <!-- THÔNG BÁO -->
    @if(session('success'))
    <div class="alert" style="padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; color: #155724; background-color: #d4edda; border-color: #c3e6cb;">
        {{ session('success') }}
    </div>
    @endif

    <div class="product-detail">

        <!-- Bên trái: Ảnh -->
        <div class="product-detail__left">
            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
        </div>

        <!-- Bên phải: Thông tin -->
        <div class="product-detail__right">

            <h1 class="product-name">
                {{ $product->name }}
            </h1>

            <div class="product-price">
                @if($product->old_price > 0)
                <span class="old-price">
                    {{ number_format($product->old_price) }}đ
                </span>
                @endif

                <span class="current-price">
                    {{ number_format($product->price) }}đ
                </span>

                @if($product->discount > 0)
                <span class="discount">
                    -{{ $product->discount }}%
                </span>
                @endif
            </div>

            <div class="product-info">
                <p><strong>Thương hiệu:</strong> {{ $product->brand }}</p>

                <p><strong>Danh mục:</strong> {{ optional($product->category)->category_name }}</p>

                <p><strong>Số lượng:</strong> {{ $product->quantity }} sản phẩm</p>

                <p><strong>Đã bán:</strong> {{ $product->sold }}</p>

                <p><strong>Trạng thái:</strong> {{ $product->quantity > 0 ? 'Còn hàng' : 'Hết hàng' }}</p>
            </div>

            <div class="quantity">

                <span class="quantity__label">Số lượng</span>

                <div class="quantity__box">
                    <button type="button" class="quantity__btn" id="minus">-</button>
                    <input
                        type="number"
                        id="quantity"
                        value="1"
                        min="1"
                        max="{{ $product->quantity }}"
                        readonly>
                    <button type="button" class="quantity__btn" id="plus">+</button>
                </div>

                <span class="quantity__stock">
                    {{ $product->quantity }} sản phẩm có sẵn
                </span>

            </div>

            <div class="product-btn">

                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <!-- Giá trị này sẽ được JS cập nhật -->
                    <input
                        type="hidden"
                        name="quantity"
                        id="cart_quantity"
                        value="1">

                    <div class="product-btn-group" style="display: flex; gap: 10px;">

                        <button
                            type="submit"
                            name="action"
                            value="add_to_cart"
                            class="btn btn--primary"
                            style="background-color: #009688;">
                            Thêm vào giỏ hàng
                        </button>

                        <button
                            type="submit"
                            name="action"
                            value="buy_now"
                            class="btn btn--primary"
                            style="background-color: #ee4d2d;">
                            Mua ngay
                        </button>

                        @php
                            $isFavorite = \Illuminate\Support\Facades\Auth::check() && \App\Models\Favorite::where('user_id', \Illuminate\Support\Facades\Auth::id())->where('product_id', $product->id)->exists();
                        @endphp
                        <button 
                            type="submit" 
                            name="action"
                            value="toggle_favorite"
                            formaction="{{ route('favorites.toggle', $product->id) }}"
                            class="btn btn--normal" 
                            style="color: {{ $isFavorite ? '#fff' : '#555' }}; background-color: {{ $isFavorite ? '#ee4d2d' : '#fff' }}; border: 1px solid {{ $isFavorite ? '#ee4d2d' : '#ddd' }};">
                            <i class="fa-solid fa-heart" style="color: {{ $isFavorite ? '#fff' : '#ee4d2d' }}; margin-right: 5px;"></i> {{ $isFavorite ? 'Đã yêu thích' : 'Yêu thích' }}
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <!-- Mô tả -->
    <div class="product-description">

        <h2>Mô tả sản phẩm</h2>

        <div class="description-content">
            {!! nl2br(e($product->description)) !!}
        </div>

    </div>

    <!-- Đánh giá sản phẩm -->
    <div class="product-description" id="review-section">
        <h2>Đánh giá sản phẩm ({{ $product->reviews->count() }})</h2>
        
        @auth
            @if($hasPurchased)
            <div style="margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #eee;">
                <form action="{{ route('product.review', $product->id) }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: bold; margin-bottom: 5px; font-size: 1.4rem;">Chọn số sao:</label>
                        <div style="font-size: 1.5rem; cursor: pointer;">
                            <input type="radio" name="rating" value="5" id="rate-5" checked> <label for="rate-5" style="margin-right: 15px;">5 <i class="fa-solid fa-star" style="color: #ffc107;"></i></label>
                            <input type="radio" name="rating" value="4" id="rate-4"> <label for="rate-4" style="margin-right: 15px;">4 <i class="fa-solid fa-star" style="color: #ffc107;"></i></label>
                            <input type="radio" name="rating" value="3" id="rate-3"> <label for="rate-3" style="margin-right: 15px;">3 <i class="fa-solid fa-star" style="color: #ffc107;"></i></label>
                            <input type="radio" name="rating" value="2" id="rate-2"> <label for="rate-2" style="margin-right: 15px;">2 <i class="fa-solid fa-star" style="color: #ffc107;"></i></label>
                            <input type="radio" name="rating" value="1" id="rate-1"> <label for="rate-1">1 <i class="fa-solid fa-star" style="color: #ffc107;"></i></label>
                        </div>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <textarea name="comment" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1.4rem;" placeholder="Nhập bình luận của bạn về sản phẩm này..."></textarea>
                    </div>
                    <button type="submit" style="background: #ee4d2d; color: #fff; border: none; padding: 10px 20px; border-radius: 4px; font-size: 1.4rem; cursor: pointer; font-weight: 500;">Gửi đánh giá</button>
                </form>
            </div>
            @else
            <div style="margin-bottom: 30px; padding: 15px; background: #f9f9f9; border-radius: 4px; font-size: 1.4rem;">
                Bạn cần mua và hoàn thành đơn hàng cho sản phẩm này để có thể gửi đánh giá.
            </div>
            @endif
        @else
        <div style="margin-bottom: 30px; padding: 15px; background: #f9f9f9; border-radius: 4px; font-size: 1.4rem;">
            Vui lòng <a href="{{ route('login') }}" style="color: #ee4d2d; font-weight: bold; text-decoration: none;">đăng nhập</a> để gửi đánh giá.
        </div>
        @endauth

        <div class="review-list">
            @forelse($product->reviews as $review)
            <div style="margin-bottom: 20px; border-bottom: 1px solid #f0f0f0; padding-bottom: 15px;">
                <div style="display: flex; align-items: center; margin-bottom: 5px;">
                    <img src="{{ asset('assets/img/iconuser.png') }}" style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
                    <div>
                        <div style="font-weight: bold; font-size: 1.4rem;">{{ $review->user->name }}</div>
                        <div style="font-size: 1.2rem;">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-solid fa-star" style="color: {{ $i <= $review->rating ? '#ffc107' : '#e0e0e0' }}"></i>
                            @endfor
                        </div>
                    </div>
                </div>
                <div style="color: #888; font-size: 1.2rem; margin-bottom: 10px;">{{ $review->created_at->format('d/m/Y H:i') }}</div>
                <div style="font-size: 1.4rem; color: #333; line-height: 1.5;">
                    {{ $review->comment }}
                </div>
            </div>
            @empty
            <div style="color: #888; font-style: italic; font-size: 1.4rem;">Chưa có đánh giá nào cho sản phẩm này.</div>
            @endforelse
        </div>
    </div>
    
    @if($relatedProducts->count() > 0)
    <div class="related-products">
        <h2>Sản phẩm liên quan</h2>

        <div class="related-products__list">
            @foreach($relatedProducts as $row)
                <div class="related-product-item">
                    <a href="{{ route('product.detail', $row->id) }}">
                        <img src="{{ asset($row->image) }}" alt="{{ $row->name }}">
                        <h4>{{ $row->name }}</h4>
                        <p class="related-price">
                            {{ number_format($row->price) }}đ
                        </p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<script>
const minus = document.getElementById("minus");
const plus = document.getElementById("plus");
const quantity = document.getElementById("quantity");
const cartQuantity = document.getElementById("cart_quantity");

const min = 1;
const max = {{ $product->quantity }};

function updateButtonState() {
    const value = parseInt(quantity.value);
    minus.disabled = (value <= min);
    plus.disabled = (value >= max);
    cartQuantity.value = value;
}

minus.addEventListener("click", function () {
    let value = parseInt(quantity.value);
    if (value > min) {
        quantity.value = value - 1;
        updateButtonState();
    }
});

plus.addEventListener("click", function () {
    let value = parseInt(quantity.value);
    if (value < max) {
        quantity.value = value + 1;
        updateButtonState();
    }
});

updateButtonState();
</script>
@endsection
