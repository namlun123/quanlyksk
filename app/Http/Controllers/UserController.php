<?php

namespace App\Http\Controllers;

use App\Http\Middleware\TKBN;
use App\Http\Middleware\User;
use Illuminate\Http\Request;
use App\Models\Benhnhan as ModelsBN;
use App\Models\TKbenhnhan as ModelsTKBN;
use App\Models\User as ModelsUser;
use App\Models\Enroll;

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
            'password' => 'required||max:100',
             'password_confirmation' => 'required|same:new_password',
            'ngaysinh' => 'required|before:today',
            'gioitinh' => 'required',
            'diachi' => 'required',
            'province' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'sdt' => 'required|unique:info_patients|max:10',
        ], [
            'name.required' => 'Tên không được để trống.',
            'name.max' => 'Tên không được vượt quá 100 ký tự.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã được sử dụng.',
            'email.max' => 'Email không được vượt quá 100 ký tự.',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.confirmed' => 'Mật khẩu nhập lại không khớp.',
            'password_confirmation.required' => 'Mật khẩu nhập lại không khớp',
            'password.max' => 'Mật khẩu không được vượt quá 100 ký tự.',
            'ngaysinh.required' => 'Ngày sinh không được để trống.',
            'ngaysinh.date' => 'Ngày sinh không hợp lệ.',
            'ngaysinh.before' => 'Ngày sinh phải trước ngày hôm nay.',
            'gioitinh.required' => 'Giới tính không được để trống.',
            'diachi.required' => 'Địa chỉ không được để trống.',
            'province.required' => 'Vui lòng chọn tỉnh/thành phố.',
            'district.required' => 'Vui lòng chọn quận/huyện.',
            'ward.required' => 'Vui lòng chọn phường/xã.',
            'sdt.required' => 'Số điện thoại không được để trống.',
            'sdt.digits' => 'Số điện thoại phải đúng 10 chữ số.',
            'sdt.unique' => 'Số điện thoại đã được sử dụng.',
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

        $bn->save();

        $user_id['user_id'] = $bn->id;
        $tkbn = new ModelsTKBN();
        $tkbn->email = $data['email'];
        $tkbn->password = Hash::make($data['password']);
        $tkbn->user_id = $user_id['user_id'];
        $tkbn->created_by = $bn->created_by;
        $tkbn->save();

        return Redirect::to('log-in')->with('status', 'Đăng ký thành công!');
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
    public function user_profile() {
        $user = Auth::guard('patients')->user();
        return view('pages.user_profile.user_profile', ['user'=>$user]);
    }
    public function update_profile(Request $request, $id) {
        $user = Auth::guard('patients')->user();
        $user_id = DB::table('patients')->where('id', $id)->value('user_id');
        $bn = ModelsBN::find($user_id);
        if ($bn) {
            // Cập nhật thông tin của `thisinhs`
            $bn->HoTen = $request->input('hoten');
            $bn->NgaySinh = $request->input('ngaysinh');
            $bn->GioiTinh  = $request->input('gioitinh');
            $bn->DiaChi = $request->input('diachi');
            $bn->province  = $request->input('province');
            $bn->district = $request->input('district');
            $bn->ward = $request->input('ward');
            $bn->sdt  = $request->input('sdt');
            $bn->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
            $bn->save();  // Lưu các thay đổi vào cơ sở dữ liệu

            Session()->put('message', 'Cập nhật thông tin cá nhân thành công');
            return Redirect::to('/user-profile');
        }
    }
    public function showChangePasswordForm()
    {
        $user = Auth::guard('patients')->user();
        return view('pages.user_profile.change-password', ['user'=>$user]); // View where user can input current and new passwords
    }
    public function changePassword(Request $request)
    {
        // Validate the request data
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed',
            'new_password_confirmation' => 'required|same:new_password', // Validate confirmation password
        ]);
    
        // Check if the current password is correct
        if (!Hash::check($request->current_password, Auth::guard('patients')->user()->password)) {
            return redirect()->back()->withInput()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
        }
    
        // Update the password
        Auth::guard('patients')->user()->password = Hash::make($request->new_password);
        Auth::guard('patients')->user()->save();
    
        // Redirect with success message
        session()->flash('success', 'Mật khẩu đã được đổi thành công!');
        return redirect()->route('user-profile'); // Redirect to the profile page
    }
    public function huongdankham()
    {   
        $user = Auth::guard('patients')->user();
        return view('pages.information.huongdankham', ['user'=>$user]);
    }
    public function enroll_history() {
        $user = Auth::guard('patients')->user();
        return view('pages.lichsukham.enroll_history', ['user'=>$user]);
    }
    public function showPdf($id)
    {
        // Truy vấn Enroll 
        $enroll = Enroll::where('id', $id)->firstOrFail();

        // Kiểm tra nếu có kết quả PDF và trả về
        if ($enroll->result_pdf) {
            $filePath = public_path($enroll->result_pdf); // Đường dẫn trong thư mục public
            if (file_exists($filePath)) {
                return response()->file($filePath);
            } else {
                return redirect()->back()->withErrors(['message' => 'File PDF không tồn tại']);
            }
        } else {
            return redirect()->back()->withErrors(['message' => 'Không tìm thấy PDF']);
        }
    }

    public function edit_enroll($enroll_id) {
        // $user = Auth::guard('khs')->user();
        // $all_location = DB::table('tbl_location')->get();
        // $all_baithi = DB::table('tbl_bai_thi')->get();
        // $all_lich_thi = DB::table('tbl_lich_thi')->get();
        // $all_infor = DB::table('thisinhs')
        //     ->join('enrolls', 'enrolls.user_id', '=', 'thisinhs.id')
        //     ->join('khs', 'khs.user_id', '=', 'thisinhs.id')
        //     ->select(
        //         'enrolls.*',
        //         'thisinhs.*',
        //         'khs.*',
        //         'enrolls.id as enroll_id',
        //         'thisinhs.id as thisinhs_id',
        //         'khs.id as khs_id'
        //     )->where('enrolls.id', $enroll_id)->get();
        // return view('pages.lichsuthi.edit_enroll', ['user' => $user], compact('all_infor', 'enroll_id', 'all_location', 'all_baithi', 'all_lich_thi'));
    }

    public function update_enroll(Request $request, $enroll_id) {
        // $user_auth = Auth::guard('khs')->user();
        // $user_id = DB::table('enrolls')->where('id', $enroll_id)->value('user_id');
        // $khs_id = DB::table('enrolls')->join('khs', 'khs.user_id', '=', 'enrolls.user_id')->where('enrolls.user_id', $user_id)->value('khs.id');
        // $ts_id = DB::table('enrolls')->join('thisinhs', 'enrolls.user_id', '=', 'thisinhs.id')->value('thisinhs.id');
        // $trang_thai = DB::table('enrolls')->where('id', $enroll_id)->value('trangthai');
        // $user = session('user_id');
        // $data = array();
        // $data_khs = array();
        // $data_ts['hoten'] = $request->hoten;
        // $data_ts['ngaysinh'] = $request->ngaysinh;
        // $data_ts['gioitinh'] = $request->gioitinh;
        // $data_ts['cccd'] = $request->cccd;
        // $data_ts['ngaycccd'] = $request->ngaycccd;
        // $data_ts['noicap'] = $request->noicap;
        // $data_ts['diachi'] = $request->diachi;
        // $data_ts['province'] = $request->province;
        // $data_ts['district'] = $request->district;
        // $data_ts['ward'] = $request->ward;
        // $data_ts['sdt'] = $request->sdt;
        // $data_khs['email'] = $request->email;
        // $data_enroll['target'] = $request->target;
        // $data_enroll['baithi_id'] = $request->baithi_id;
        // $data_enroll['diadiemthi_id'] = $request->diadiemthi_id;
        // $data_enroll['lichthi_id'] = $request->lichthi_id;
        // $data_enroll['updated_at'] = Carbon::now('Asia/Ho_Chi_Minh');
        // $data_enroll['updated_by_user'] = $user;

        // $get_image = $request->file('anh');
        // if ($get_image) {
        //     $get_name_image = $get_image->getClientOriginalName();
        //     $name_image = current(explode('.', $get_name_image));
        //     $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
        //     $get_image->move('public/uploads/dangkythi', $new_image);
        //     $data['anh'] = $new_image;
        //     DB::table('enrolls')->where('id', $enroll_id)->update($data);
        //     Session()->put('message', 'Cập nhật thông tin đăng ký thi thành công');
        //     return Redirect::to('enroll-history');
        // }

        // if ($trang_thai != '1') {
        //     DB::table('khs')->where('id', $khs_id)->update($data_khs);
        //     DB::table('thisinhs')->where('id', $ts_id)->update($data_ts);
        //     DB::table('enrolls')->where('id', $enroll_id)->update($data_enroll);
        //     Session()->put('message', 'Cập nhật thông tin đăng ký thi thành công');
        //     return Redirect::to('enroll-history');
        // } else {
        //     return back()->withInput()->withErrors(['enroll_id' => 'Bài thi đã được thanh toán, không thể sửa thông tin']);
        // }
    }

    public function delete_enroll($enroll_id) {
        // $user = Auth::guard('khs')->user();
        // $trang_thai = DB::table('enrolls')->where('id', $enroll_id)->value('trangthai');
        // if ($trang_thai != 1) {
        //     DB::table('enrolls')->where('id', $enroll_id)->delete();
        //     Session()->put('message', 'Xóa thông tin đăng ký thành công');
        //     return Redirect::to('enroll-history');
        // } else {
        //     return back()->withInput()->withErrors(['enroll_id' => 'Bài thi đã được thanh toán, không thể xóa thông tin']);
        // }
    }

}