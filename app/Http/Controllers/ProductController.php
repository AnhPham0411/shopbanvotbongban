<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function detail($id)
    {
        $product = Product::with(['category', 'reviews.user' => function($q) {
            $q->orderBy('created_at', 'desc');
        }])->findOrFail($id);

        // Lấy sản phẩm liên quan (cùng danh mục, trừ sản phẩm hiện tại)
        $relatedProducts = Product::where('category_id', $product->category_id)
                                  ->where('id', '!=', $product->id)
                                  ->inRandomOrder()
                                  ->take(4)
                                  ->get();
                                  
        return view('product.detail', compact('product', 'relatedProducts'));
    }

    public function storeReview(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        \App\Models\Review::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'product_id' => $id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }
}
