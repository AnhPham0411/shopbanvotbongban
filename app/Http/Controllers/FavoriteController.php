<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Favorite::with('product')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.favorites', compact('favorites'));
    }

    public function toggle(Request $request, $productId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thêm vào danh sách yêu thích!');
        }

        $userId = Auth::id();
        $favorite = Favorite::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return redirect()->back()->with('success', 'Đã bỏ sản phẩm khỏi danh sách yêu thích!');
        } else {
            Favorite::create([
                'user_id' => $userId,
                'product_id' => $productId
            ]);
            return redirect()->back()->with('success', 'Đã thêm sản phẩm vào danh sách yêu thích!');
        }
    }
}
