<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\InfoAdmin; // Import model
class ManageAdminController extends Controller
{
    public function info_admin()
    {
        $adminUser = Auth::guard('admins')->user();
        return view('admin.tkadmin.info_admin', ['user'=>$adminUser]);
    }
    public function add_tkadmin()
    {
        $adminUser = Auth::guard('admins')->user();
        return view('admin.tkadmin.add_tkadmin', ['user'=>$adminUser]);
    }

    public function save_tkadmin(Request $request)
    {

        $validatedData = $request->validate([
            'email' => 'required|email|unique:khs|max:255',
            'password' => 'required|min:1|max:100',
            'hoten' => 'required|string|max:255',
            'ngaysinh' => 'required|date|before:today',
            'sdt' => 'required|string|max:10', ]);
        
        $admin = new InfoAdmin();
        $admin -> HoTen = $request -> hoten;
        $admin -> NgaySinh = $request -> ngaysinh;
        $admin -> SDT = $request -> sdt;
        $admin -> save();

        $adminId = $admin -> id;
         
        $adminfo = new tkadmin();
        $adminfo -> email = $request -> email;
        $adminfo -> password = Hash::make($request->password);
        $adminfo -> admin_id = $adminId;
        $adminfo -> save();
        return redirect::to('admin/all-tkadmin');


    }

    public function all_tkadmin()
    {
        $adminUser = Auth::guard('admins')->user();
        $all_tkadmin = DB::table('admins') ->get();
        return view('admin.tkadmin.all_tkadmin', ['user' => $adminUser], ['all_tkadmin' => $all_tkadmin]);
    }

    public function all_admins() {
        $adminUser = Auth::guard('admins')->user();
        $all_admins = DB::table('info_admins')->orderBy('id', 'desc')->get();
        return view('admin.tkadmin.all_admins', ['user'=>$adminUser], ['all_admins'=>$all_admins]);
    }

    public function edit_tkadmin($tkadmin_id)
    {
        $adminUser = Auth::guard('admins')->user();
        $tkadmin = DB::table('admins')->where('id', $tkadmin_id)->first();
        $all_tkadmin = DB::table('admins')->get();
        return view('admin.tkadmin.edit_tkadmin', ['user' => $adminUser], compact('tkadmin','all_tkadmin'));
    }

    public function edit_admins($admin_id)
    {
        $adminUser = Auth::guard('admins')->user();
        $admins = DB::table('info_admins')->where('id', $admin_id)->first();
        $all_admins = DB::table('info_admins')->get();
        return view('admin.tkadmin.edit_admins', ['user' => $adminUser], compact('admins','all_admins'));
    }

    public function update_admins(Request $request, $admin_id)
    {
        $validatedData = $request->validate([
            'hoten' => 'required|string|max:255',
            'ngaysinh' => 'required|date|before:today',
            'sdt' => 'required|string|max:10',
        ]);
        $existingSDT = DB::table('info_admins')->where('SDT', $request->sdt)->where('id', '!=', $admin_id)->exists();
        if($existingSDT)
        {
            return back()->withInput()->withErrors(['SDT' => 'Số điện thoại này đã tồn tại']);
        }
        else
        {
            DB::table('info_admins')->where('id', $admin_id)->update($validatedData);
            Session()->put('message', 'Cập nhật thông tin admin thành công');
            return Redirect::to('admin/all-admins');
        }

}


    

    public function update_tkadmin(Request $request, $tkadmin_id)
    {
        $adminUser = Auth::guard('admins')->user();
        $data = array();
        $data['name'] = $request-> username;
        $data['email'] = $request-> email;
        $data['password'] = $request-> matkhau;

        $existingEmail = DB::table('admins')->where('email', $request->email)->exists();
        $request->validate([
            'email' => 'required|email',
        ]);
        
        if ($existingEmail) {
            return back()->withInput()->withErrors(['email' => 'Email này đã tồn tại']);
        }
        else {
            DB::table('admins')->where('id', $tkadmin_id) ->update($data);
            
            Session()->put('message', 'Sửa thành công');
            return Redirect::to('admin/all-tkadmin');
        }


    }

    public function delete_tkadmin($tkadmin_id)
    {
        $adminUser = Auth::guard('admins')->user();
        $tkadmin = DB::table('admins')->where('id', $tkadmin_id)->first();
        DB::table('admins')->where('id', $tkadmin_id) ->delete();
        Session()->put('message', 'Xóa tài khoản thành công');
        return Redirect::to('admin/all-tkadmin');
    }

    public function delete_admins($admin_id)
    {
        $admin = DB::table('info_admins')->where('id', $admin_id)->first();
        if (!$admin) {
            return back()->withErrors(['message' => 'Không tìm thấy admin']);
        }
        $adminId = $admin->id;
        DB::table('info_admins')->where('id', $admin_id)->delete();
        DB::table('admins')->where('id', $adminId)->delete();
        Session()->put('message', 'Xóa admin thành công');
        return Redirect::to('admin/all-admins');
    }

    public function password_tkadmin($id)
    {
        $admin = Admin::findOrFail($id);
        return view('admin.tkadmin.password_tkadmin', ['user' => $admin], compact('admin'));
    }

}
