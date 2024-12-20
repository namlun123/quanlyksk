<?php

namespace App\Http\Controllers;

use App\Models\Chuyenkhoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChuyenKhoaController extends Controller
{
    // Hiển thị danh sách chuyên khoa
    public function all_chuyenkhoa()
    {
        $adminUser = Auth::guard('admins')->user();
        $all_chuyenkhoa = DB::table('specialties')->orderBy('specialty_id', 'desc')->get();

        return view('admin.chuyenkhoa.all_chuyenkhoa', [
            'user' => $adminUser,
            'all_chuyenkhoa' => $all_chuyenkhoa
        ]);
    }

    // Hiển thị form thêm mới chuyên khoa
    public function add_chuyenkhoa()
    {
        $adminUser = Auth::guard('admins')->user();
        return view('admin.chuyenkhoa.add_chuyenkhoa', ['user' => $adminUser]);
    }

    // Lưu thông tin chuyên khoa vào database
    public function save_chuyenkhoa(Request $request)
    {
        // Lấy ID admin từ session
        $adminId = session('admin_id');

        // Validate dữ liệu đầu vào
        $validatedData = $request->validate([
            'specialty' => 'required|string|max:255',
            'mota' => 'required|string|max:255',
        ]);

        // Tạo mới chuyên khoa
        $chuyenkhoa = new Chuyenkhoa();
        $chuyenkhoa->specialty = $request->specialty; // Đúng tên input form
        $chuyenkhoa->mota = $request->mota; // Đúng tên input form
        $chuyenkhoa->created_by = $adminId; // Thêm ID người tạo
        $chuyenkhoa->save();

        // Redirect sau khi lưu thành công
        return redirect()->route('admin.all.chuyenkhoa')->with('success', 'Chuyên khoa đã được thêm thành công!');
    }
    public function edit_chuyenkhoa($id)
{
    $adminUser = Auth::guard('admins')->user();

    // Fetch the specialty by its ID
    $chuyenkhoa = Chuyenkhoa::where('specialty_id', $id)->first();

    if (!$chuyenkhoa) {
        return back()->withErrors(['message' => 'Không tìm thấy chuyên khoa']);
    }

    // Return the edit view
    return view('admin.chuyenkhoa.edit_chuyenkhoa', [
        'user' => $adminUser,
        'chuyenkhoa' => $chuyenkhoa
    ]);
}
public function update_chuyenkhoa(Request $request, $id)
{
    // Validate dữ liệu đầu vào
    $validatedData = $request->validate([
        'specialty' => 'required|string|max:255',
        'mota' => 'required|string|max:255',
    ]);

    // Cập nhật thông tin chuyên khoa
    DB::table('specialties')
        ->where('specialty_id', $id)
        ->update([
            'specialty' => $request->specialty,
            'mota' => $request->mota,
            'updated_at' => now(),
        ]);

    // Thông báo cập nhật thành công
    session()->put('message', 'Cập nhật thông tin chuyên khoa thành công');

    // Chuyển hướng về trang danh sách
    return redirect()->route('admin.all.chuyenkhoa');
}
    public function delete_chuyenkhoa($specialty_id) 
    {
        // Fetch the record to be deleted
        $chuyenkhoa = DB::table('specialties')->where('specialty_id', $specialty_id)->first();

        // Check if the record exists
        if (!$chuyenkhoa) {
            return back()->withErrors(['message' => 'Không tìm thấy chuyên khoa']);
        }

        // Get the ID of the current authenticated admin
        $adminId = Auth::guard('admins')->id();

        // Update the record to log the admin who deleted it
        // DB::table('specialties')
        //     ->where('specialty_id', $specialty_id)
        //     ->update(['deleted_by' => $adminId]);

        // Perform the actual deletion
        DB::table('specialties')->where('specialty_id', $specialty_id)->delete();

        // Store a success message in the session
        session()->put('message', 'Xóa chuyên khoa thành công bởi admin ID: ' . $adminId);

        // Redirect to the specialties list
        return redirect()->route('admin.all.chuyenkhoa');
    }
    
}
