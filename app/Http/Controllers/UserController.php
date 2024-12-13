<?php

namespace App\Http\Controllers;

use App\Http\Middleware\BN;
use App\Http\Middleware\User;
use Illuminate\Http\Request;
use App\Models\Benhnhan as ModelsBN;
use App\Models\TKbenhnhan as ModelsTKBN;
use App\Models\User as ModelsUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index() {
        $user = Auth::guard('patients')->user();
        return view('pages.home', ['user' => $user]);
    }
    public function userlogin() {
        return view('pages.login_user');
    }

    public function userregister() {
        return view('pages.register_user');
    }
    public function register_kh(Request $request) {
        $data = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|unique:patients|max:100',
            'password' => 'required|required_with:password_confirmed|same:password|max:100',
            'ngaysinh' => 'required|before:today',
            'gioitinh' => 'required',
            'diachi' => 'required',
            'province' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'sdt' => 'required|unique:info_patients|max:10',
        ], [
            'email.unique' => 'Email không hợp lệ',
            'name.required' => 'Phải có tên',
            'email.required' => 'Phải có Email',
            'password.required' => 'Phải có mật khẩu',
            'ngaysinh.required' => 'Phải nhập ngày sinh',
            'gioitinh.required' => 'Phải chọn giới tính',
            'diachi.required' => 'Phải nhập địa chỉ',
            'province.required' => 'Phải chọn tỉnh/thành phố',
            'district.required' => 'Phải chọn quận/huyện',
            'ward.required' => 'Phải chọn phường/xã',
            'sdt.required' => 'Phải nhập số điện thoại',
        ]);

        $bn = new ModelsBN();
        $bn->HoTen = $data['name'];
        $bn->NgaySinh = $data['ngaysinh'];
        $bn->GioiTinh  = $data['gioitinh'];
       
        $bn->DiaChi = $data['diachi'];
        $bn->province  = $data['province'];
        $bn->district = $data['district'];
        $bn->ward = $data['ward'];
        $bn->sdt  = $data['sdt'];
        $bn->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $bn->created_by = Auth::id() ?? 0;  // Hoặc NULL nếu không cần giá trị cụ thể
     // Kiểm tra xem có bản ghi nào trong bảng admins
     $admin = DB::table('admins')->first();
     if ($admin) {
         $bn->created_by = $admin->id;  // Liên kết với admin đã có
     } else {
         $bn->created_by = NULL;  // Giá trị mặc định nếu không có admin nào
     }
        $bn->save();

        $user_id['user_id'] = $bn->id;
        $tkbn = new ModelsTKBN();
        $tkbn->email = $data['email'];
        $tkbn->password = Hash::make($data['password']);
        $tkbn->user_id = $user_id['user_id'];
        $tkbn->created_by = $bn->created_by;
        $tkbn->save();

        // return Redirect()->back()->with('status', 'Đăng ký thành công');
        return Redirect::to('log-in');
    }

    public function login_kh(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'captcha' => 'required|captcha',
        ]);

        if ($validator->fails()) {
            return redirect()->route('userlogin')
                             ->withErrors($validator)
                             ->withInput();
        }
        $credentials = $request->only('email', 'password');
        if (Auth::guard('patients')->attempt($credentials))  {
            // If login is successful, redirect to the home page
            return redirect()->route('pages.home');
        } else {
            // If login fails, redirect back to the login page with an error message
            return redirect()->route('userlogin')->withErrors(['email' => 'Đăng nhập không thành công']);
        }
    }
    public function sign_out() {
        Auth::guard('patients')->logout();
        return Redirect('/log-in');
    }

}
