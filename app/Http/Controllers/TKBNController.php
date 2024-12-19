<?php


namespace App\Http\Controllers;

use App\Models\Benhnhan;
use App\Models\TKbenhnhan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TKBNController extends Controller
{
    public function all_tkbn() {
        $adminUser = Auth::guard('admins')->user();
        $all_tkbn = DB::table('patients')->orderBy('id', 'desc')->get();
        return view('admin.benhnhan.all_tkbn', ['user'=>$adminUser], ['all_tkbn'=>$all_tkbn]);
    }
    public function add_tkbn() {
        $adminUser = Auth::guard('admins')->user();
        return view('admin.benhnhan.add_tkbn', ['user'=>$adminUser]);
    }
    public function save_tkbn(Request $request)
    {
        $adminId = session('admin_id');
        $validatedData = $request->validate([
            'email' => 'required|email:rfc,dns|unique:patients|max:255',
            'password' => 'required|min:1|max:100',
            'hoten' => 'required|string|max:255',
            'ngaysinh' => 'required|date|before:today',
            'gioitinh' => 'required|in:0,1',
        
            'diachi' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'ward' => 'required|string|max:255',
            'sdt' => 'required|string|max:10',
        ]);
        $bn = new Benhnhan();
        $bn->HoTen = $request->hoten;
        $bn->NgaySinh = $request->ngaysinh;
        $bn->GioiTinh = $request->gioitinh;
        $bn->DiaChi = $request->diachi;
        $bn->province = $request->province;
        $bn->district = $request->district;
        $bn->ward = $request->ward;
        $bn->sdt = $request->sdt;
        $bn->created_by = $adminId;
        $bn->save();

        $bnId = $bn->id;

        $khs = new TKbenhnhan();
        $khs->email = $request->email;
        $khs->password = Hash::make($request->password);
        $khs->user_id = $bnId; // Tham chiếu đến id của bảng bns
        $khs->created_by = $adminId;
        $khs->save();
        return Redirect::to('admin/all-tkbn');
    }
    public function delete_tkbn($id) {
        $khs = DB::table('patients')->where('id', $id)->first();
        if (!$khs) {
            return back()->withErrors(['message' => 'Không tìm thấy bệnh nhân']);
        }
        $userId = $khs->user_id;
        DB::table('patients')->where('id', $id)->delete();
        DB::table('info_patients')->where('id', $userId)->delete();
        Session()->put('message', 'Xóa bệnh nhân thành công');
        return Redirect::to('admin/all-tkbn');
    }
    public function all_bn() {
        $adminUser = Auth::guard('admins')->user();
        $all_bn = DB::table('info_patients')->orderBy('id', 'desc')->get();
        return view('admin.benhnhan.all_bn', ['user'=>$adminUser], ['all_bn'=>$all_bn]);
    }
    public function edit_bn($id) {
        $adminUser = Auth::guard('admins')->user();
        $bn = DB::table('info_patients')->where('id', $id)->first();
        $all_bn = DB::table('info_patients')->get();
        return view('admin.benhnhan.edit_bn', ['user' => $adminUser], compact('bn', 'all_bn'));
    }
    public function update_bn(Request $request, $id)
    {
    $validatedData = $request->validate([
        'hoten' => 'required|string|max:255',
        'ngaysinh' => 'required|date|before:today',
        'diachi' => 'required|string|max:255',
        'province' => 'required|string|max:255',
        'district' => 'required|string|max:255',
        'ward' => 'required|string|max:255',
        'sdt' => 'required|string|max:10',
    ]);
    if ($request->gioitinh === null) {
        $request->request->remove('gioitinh');
    }
    DB::table('info_patients')->where('id', $id)->update($validatedData);
    Session()->put('message', 'Cập nhật thông tin bệnh nhân thành công');
    return Redirect::to('admin/all-bn');
    }
    public function delete_bn($id) {
        $bn = DB::table('info_patients')->where('id', $id)->first();
        if (!$bn) {
            return back()->withErrors(['message' => 'Không tìm thấy bệnh nhân']);
        }
        $userId = $bn->id;
        DB::table('patients')->where('user_id', $userId)->delete();
        DB::table('info_patients')->where('id', $id)->delete();
        Session()->put('message', 'Xóa bệnh nhân thành công');
        return Redirect::to('admin/all-bn');
    }
}
