<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Fix for old plain text passwords or just standard bcrypt if we re-seeded
        // The LegacyDataSeeder copied passwords as is. If they were plaintext in old PHP,
        // Auth::attempt won't work because it expects bcrypt.
        // Let's first try normal Auth
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Đăng nhập thành công!');
        }
        
        // Fallback for legacy plain text passwords
        $user = User::where('email', $credentials['email'])->first();
        if ($user && $user->password === $credentials['password']) {
            // Update to bcrypt for future
            $user->password = Hash::make($credentials['password']);
            $user->save();
            
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Đăng nhập thành công!');
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.unique' => 'Email này đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => 'user'
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Đăng ký tài khoản thành công!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
    }

    public function orders()
    {
        $orders = \App\Models\Order::where('user_id', Auth::id())
                                   ->orderBy('created_at', 'desc')
                                   ->get();
        return view('user.orders', compact('orders'));
    }

    public function confirmReceived($id)
    {
        $order = \App\Models\Order::where('id', $id)
                                  ->where('user_id', Auth::id())
                                  ->firstOrFail();
        
        if ($order->status == 'shipping') {
            $order->status = 'completed';
            $order->save();
            return redirect()->back()->with('success', 'Xác nhận đã nhận hàng thành công!');
        }

        return redirect()->back()->withErrors('Không thể cập nhật trạng thái đơn hàng này.');
    }
}
