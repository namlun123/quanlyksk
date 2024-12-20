<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoaiXNController extends Controller
{
    // Hiển thị danh sách loại xét nghiệm
    public function all_loaixn()
    {
        $adminUser = Auth::guard('admins')->user();
        $all_loaixn = DB::table('loaixn')->orderBy('xetnghiem_id', 'desc')->get();

        return view('admin.loaixn.all_loaixn', [
            'user' => $adminUser,
            'all_loaixn' => $all_loaixn
        ]);
    }

    // Hiển thị form thêm mới loại xét nghiệm
    public function add_loaixn()
    {
        $adminUser = Auth::guard('admins')->user();
        return view('admin.loaixn.add_loaixn', ['user' => $adminUser]);
    }

    // Lưu thông tin loại xét nghiệm vào database
    public function save_loaixn(Request $request)
    {
        $adminId = session('admin_id');

        $validatedData = $request->validate([
            'tenxn' => 'required|string|max:255',
        ]);

        DB::table('loaixn')->insert([
            'tenxn' => $request->tenxn,
        ]);

        return redirect()->route('admin.all.loaixn')->with('success', 'Loại xét nghiệm đã được thêm thành công!');
    }

    public function edit_loaixn($id)
    {
        $adminUser = Auth::guard('admins')->user();

        $loaixn = DB::table('loaixn')->where('xetnghiem_id', $id)->first();

        if (!$loaixn) {
            return back()->withErrors(['message' => 'Không tìm thấy loại xét nghiệm']);
        }

        return view('admin.loaixn.edit_loaixn', [
            'user' => $adminUser,
            'loaixn' => $loaixn
        ]);
    }

    public function update_loaixn(Request $request, $id)
    {
        $validatedData = $request->validate([
            'tenxn' => 'required|string|max:255',
        ]);

        DB::table('loaixn')
            ->where('xetnghiem_id', $id)
            ->update([
                'tenxn' => $request->tenxn,
            ]);

        session()->put('message', 'Cập nhật thông tin loại xét nghiệm thành công');

        return redirect()->route('admin.all.loaixn');
    }

    public function delete_loaixn($xetnghiem_id)
    {
        $loaixn = DB::table('loaixn')->where('xetnghiem_id', $xetnghiem_id)->first();

        if (!$loaixn) {
            return back()->withErrors(['message' => 'Không tìm thấy loại xét nghiệm']);
        }

        $adminId = Auth::guard('admins')->id();

        DB::table('loaixn')->where('xetnghiem_id', $xetnghiem_id)->delete();

        session()->put('message', 'Xóa loại xét nghiệm thành công bởi admin ID: ' . $adminId);

        return redirect()->route('admin.all.loaixn');
    }
}
