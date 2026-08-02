<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Coupon;


class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session('cart', []);
        $quantity = $request->input('quantity', 1);

        if(isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->image
            ];
        }

        session(['cart' => $cart]);

        if ($request->input('action') === 'buy_now') {
            return redirect()->route('checkout');
        }

        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
    }

    public function update(Request $request)
    {
        $cart = session('cart', []);
        $quantities = $request->input('quantities', []);

        foreach ($quantities as $id => $quantity) {
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = max(1, (int)$quantity);
            }
        }

        session(['cart' => $cart]);
        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được cập nhật!');
    }

    public function remove($id)
    {
        $cart = session('cart', []);
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session(['cart' => $cart]);
        }
        return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    public function checkout()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Giỏ hàng trống!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $coupon = session('coupon');
        $discountAmount = 0;
        
        if ($coupon) {
            if ($total >= $coupon['min_order_value']) {
                if ($coupon['type'] === 'percent') {
                    $discountAmount = ($total * $coupon['value']) / 100;
                } else {
                    $discountAmount = $coupon['value'];
                }
            } else {
                // If the cart total dropped below minimum, remove coupon
                session()->forget('coupon');
                $coupon = null;
            }
        }

        // Fetch available coupons
        $availableCoupons = Coupon::where(function($q) {
                $q->whereNull('expires_at')->orWhereDate('expires_at', '>=', now()->toDateString());
            })
            ->where(function($q) {
                $q->whereNull('usage_limit')->orWhereRaw('used_count < usage_limit');
            })
            ->orderBy('min_order_value', 'asc')
            ->get();

        return view('cart.checkout', compact('cart', 'total', 'coupon', 'discountAmount', 'availableCoupons'));
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $code = trim($request->code);
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return redirect()->back()->with('error', 'Mã giảm giá không tồn tại!');
        }

        if ($coupon->expires_at && $coupon->expires_at < now()->toDateString()) {
            return redirect()->back()->with('error', 'Mã giảm giá đã hết hạn!');
        }

        if ($coupon->usage_limit !== null && $coupon->used_count >= $coupon->usage_limit) {
            return redirect()->back()->with('error', 'Mã giảm giá đã hết lượt sử dụng!');
        }

        $cart = session('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        if ($total < $coupon->min_order_value) {
            return redirect()->back()->with('error', 'Đơn hàng chưa đạt giá trị tối thiểu ' . number_format($coupon->min_order_value, 0, ',', '.') . 'đ để sử dụng mã này!');
        }

        session(['coupon' => [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'min_order_value' => $coupon->min_order_value
        ]]);

        return redirect()->back()->with('success', 'Đã áp dụng mã giảm giá!');
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        return redirect()->back()->with('success', 'Đã gỡ mã giảm giá!');
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'fullName' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'paymentMethod' => 'required|string',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Giỏ hàng trống!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $coupon = session('coupon');
        $discountAmount = 0;
        if ($coupon && $total >= $coupon['min_order_value']) {
            if ($coupon['type'] === 'percent') {
                $discountAmount = ($total * $coupon['value']) / 100;
            } else {
                $discountAmount = $coupon['value'];
            }
        }
        $finalTotal = max(0, $total - $discountAmount);

        DB::beginTransaction();
        try {
            $note = $request->note;
            if ($coupon) {
                $note .= "\n(Đã áp dụng mã giảm giá: " . $coupon['code'] . " - Giảm " . number_format($discountAmount, 0, ',', '.') . "đ)";
            }

            $order = Order::create([
                'user_id' => Auth::id(), // null nếu chưa đăng nhập
                'total' => $finalTotal,
                'status' => 'pending',
                'fullName' => $request->fullName,
                'phone' => $request->phone,
                'address' => $request->address,
                'note' => trim($note),
                'paymentMethod' => $request->paymentMethod,
            ]);

            foreach ($cart as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'name' => $item['name']
                ]);
                
                // Trừ số lượng sản phẩm (kho)
                Product::where('id', $id)->decrement('quantity', $item['quantity']);
                Product::where('id', $id)->increment('sold', $item['quantity']);
            }

            if ($coupon) {
                Coupon::where('id', $coupon['id'])->increment('used_count', 1);
            }

            DB::commit();
            session()->forget('cart');
            session()->forget('coupon');

            return redirect()->route('checkout.success')->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function success()
    {
        return view('cart.success');
    }
}
