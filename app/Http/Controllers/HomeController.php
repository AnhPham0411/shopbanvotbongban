<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('category_name', 'asc')->get();
        
        $query = Product::query();

        // Lọc theo danh mục
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Tìm kiếm
        if ($request->has('keyword') && trim($request->keyword) != '') {
            $query->where('name', 'LIKE', '%' . trim($request->keyword) . '%');
        }

        // Sắp xếp
        if ($request->has('sort') && $request->sort != '') {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('id', 'desc');
                    break;
                default:
                    $query->inRandomOrder();
                    break;
            }
        } elseif ($request->has('keyword') || $request->has('category')) {
            $query->orderBy('id', 'desc');
        } else {
            $query->inRandomOrder();
        }

        $products = $query->paginate(10)->withQueryString();

        return view('home', compact('categories', 'products'));
    }

    public function helpCenter()
    {
        return view('pages.help_center');
    }

    public function shoppingGuide()
    {
        return view('pages.shopping_guide');
    }

    public function authGuide()
    {
        return view('pages.auth_guide');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function careers()
    {
        return view('pages.careers');
    }

    public function terms()
    {
        return view('pages.terms');
    }
}
