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
use Hash;
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
    public function showstatistics() {
        $adminUser = Auth::guard('admins')->user();
        return view('admin.statistics', ['user' => $adminUser]);
    }
    // public function showdashboard() {
    //     $adminUser = Auth::guard('admins')->user();
    //     return view('admin.dashboard', ['user' => $adminUser]);
    // }
    public function dashboard(Request $request) {
        $admin_email=$request->email;
        $admin_password= bcrypt($request->password);
        $result=DB::table('admins')->where ('email',$admin_email)->where('password',$admin_password)->first();
        return view('admin.dashboard');
        // $adminUser = Auth::guard('admins')->user();
        // return view('admin.dashboard', ['user' => $adminUser]);
    }
    public function admin_logout() {
        Auth::guard('admins')->logout();
        return Redirect('admin/login');
    }

    public function showChangePasswordForm()
    {
        return view('admin.tkadmin.change-password');
    }

    // Xử lý thay đổi mật khẩu
    public function changePassword(Request $request)
    {
        // Validate the request data
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed',
            'new_password_confirmation' => 'required|same:new_password', // Validate confirmation password
        ]);
    
        // Check if the current password is correct
        if (!Hash::check($request->current_password, Auth::guard('admins')->user()->password)) {
            return redirect()->back()->withInput()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
        }
    
        // Update the password
        Auth::guard('admins')->user()->password = Hash::make($request->new_password);
        Auth::guard('admins')->user()->save();
    
        // Redirect with success message
        session()->flash('success', 'Mật khẩu đã được thay đổi thành công!');
        return redirect()->route('admin.dashboard'); // Redirect to the admin dashboard
    }
    
}
