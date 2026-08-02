<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Category;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function products()
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('admin.products', compact('products'));
    }

    public function orders()
    {
        $orders = Order::orderBy('id', 'desc')->get();
        return view('admin.orders', compact('orders'));
    }

    public function users()
    {
        $users = User::orderBy('id', 'desc')->get();
        return view('admin.users', compact('users'));
    }

    public function categories()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('admin.categories', compact('categories'));
    }

    // --- CATEGORY CRUD ---

    public function createCategory()
    {
        return view('admin.categories_create');
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate(['category_name' => 'required']);
        Category::create($data);
        return redirect()->route('admin.categories')->with('success', 'Thêm danh mục thành công');
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories_edit', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $data = $request->validate(['category_name' => 'required']);
        $category->update($data);
        return redirect()->route('admin.categories')->with('success', 'Cập nhật danh mục thành công');
    }

    public function deleteCategory($id)
    {
        Category::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Đã xóa danh mục');
    }

    // --- REVIEW MANAGEMENT ---
    
    public function reviews()
    {
        $reviews = \App\Models\Review::with(['user', 'product'])->orderBy('id', 'desc')->get();
        return view('admin.reviews', compact('reviews'));
    }
    
    public function deleteReview($id)
    {
        \App\Models\Review::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Đã xóa đánh giá');
    }
    
    // --- COUPON MANAGEMENT ---
    
    public function coupons()
    {
        $coupons = \App\Models\Coupon::orderBy('id', 'desc')->get();
        return view('admin.coupons', compact('coupons'));
    }
    
    public function createCoupon()
    {
        return view('admin.coupons_create');
    }
    
    public function storeCoupon(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|unique:coupons',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|integer|min:1',
            'min_order_value' => 'required|integer|min:0',
            'expires_at' => 'nullable|date',
            'usage_limit' => 'nullable|integer|min:1'
        ]);
        
        \App\Models\Coupon::create($data);
        return redirect()->route('admin.coupons')->with('success', 'Thêm mã giảm giá thành công');
    }
    
    public function editCoupon($id)
    {
        $coupon = \App\Models\Coupon::findOrFail($id);
        return view('admin.coupons_edit', compact('coupon'));
    }
    
    public function updateCoupon(Request $request, $id)
    {
        $coupon = \App\Models\Coupon::findOrFail($id);
        $data = $request->validate([
            'code' => 'required|unique:coupons,code,'.$id,
            'type' => 'required|in:percent,fixed',
            'value' => 'required|integer|min:1',
            'min_order_value' => 'required|integer|min:0',
            'expires_at' => 'nullable|date',
            'usage_limit' => 'nullable|integer|min:1'
        ]);
        
        $coupon->update($data);
        return redirect()->route('admin.coupons')->with('success', 'Cập nhật mã giảm giá thành công');
    }
    
    public function deleteCoupon($id)
    {
        \App\Models\Coupon::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Đã xóa mã giảm giá');
    }

    // --- PRODUCT CRUD ---

    public function createProduct()
    {
        $categories = Category::all();
        return view('admin.products_create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $data = $request->except('_token');
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $data['image'] = 'uploads/' . $filename;
        }
        Product::create($data);
        return redirect()->route('admin.products')->with('success', 'Thêm sản phẩm thành công');
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products_edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $data = $request->except('_token', '_method');
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $data['image'] = 'uploads/' . $filename;
        }
        $product->update($data);
        return redirect()->route('admin.products')->with('success', 'Cập nhật sản phẩm thành công');
    }

    public function deleteProduct($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Đã xóa sản phẩm');
    }

    // --- ORDER MANAGEMENT ---

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();
        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công');
    }
}
