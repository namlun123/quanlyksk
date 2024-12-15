<?php

namespace App\Http\Controllers;
use App\Models\Enroll;
use App\Models\Benhnhan;
use App\Models\TKbenhnhan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    public function admin_login() {
        $adminUser = Auth::guard('admins')->user();
        return view('admin.login', ['user'=>$adminUser]);
    }
    public function loginPost(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha' => 'required|captcha',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admins')->attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('admin_login')->withErrors(['email' => 'Đăng nhập không thành công']);
        }
    }
}
