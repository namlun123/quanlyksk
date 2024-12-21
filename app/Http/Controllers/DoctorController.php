<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Chuyenkhoa; // Đảm bảo Model được sử dụng đúng
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    public function all_Doctor()

    {
        $adminUser = Auth::guard('admins')->user();
        $doctors = Doctor::with(['Chuyenkhoa', 'location'])->get();
        return view('admin.doctor.all_Doctor', compact('doctors'));
    }

    public function add_Doctor() {
        $adminUser = Auth::guard('admins')->user();
        $specialties = Chuyenkhoa::all(); // Lấy danh sách chuyên khoa
        $locations = Location::all();    // Lấy danh sách địa điểm
        return view('admin.doctor.add_Doctor', compact('specialties', 'locations'));
    }

    public function save_Doctor(Request $request) {
        $adminId = session('admin_id');
        $request->validate([
            'HoTen' => 'required',
            'ChucVu' => 'required',
            'PhiCoBan' => 'required|numeric',
            'specialty_id' => 'required|exists:specialties,specialty_id', // Kiểm tra specialty_id có tồn tại trong bảng Chuyenkhoa
            'location_id' => 'required|exists:locations,location_id', // Kiểm tra location_id có tồn tại trong bảng Location
        ]);

        // Lấy ID của admin đang đăng nhập
        $adminId = Auth::guard('admins')->id();

        // Thêm bác sĩ mới vào cơ sở dữ liệu
        Doctor::create([
            'HoTen' => $request->HoTen,
            'ChucVu' => $request->ChucVu,
            'PhiCoBan' => $request->PhiCoBan,
            'specialty_id' => $request->specialty_id,
            'location_id' => $request->location_id,
            'created_by' => $adminId, // Lưu ID của admin đã thêm
        ]);

        return redirect()->route('admin.all.Doctor');
    }

    public function showDoctors()
    {
        $doctors = Doctor::all(); // Lấy tất cả các bác sĩ từ bảng doctor
        return view('doctor', compact('doctors'));
    }

    public function edit_Doctor($id) 
    {
        $doctor = Doctor::find($id); // Lấy thông tin bác sĩ theo ID
        $specialties = Chuyenkhoa::all(); // Lấy tất cả chuyên khoa
        $locations = Location::all(); // Lấy tất cả địa điểm

        return view('admin.doctor.edit_Doctor', compact('doctor', 'specialties', 'locations'));
    }

    public function update_Doctor(Request $request, $id) {
        $request->validate([
            'HoTen' => 'required',
            'ChucVu' => 'required',
            'PhiCoBan' => 'required|numeric',
        ]);

        $doctor = Doctor::findOrFail($id);
        
        // Lấy ID của admin đang đăng nhập
        $adminId = Auth::guard('admins')->id();

        // Cập nhật thông tin bác sĩ
        $doctor->update([
            'HoTen' => $request->HoTen,
            'ChucVu' => $request->ChucVu,
            'PhiCoBan' => $request->PhiCoBan,
            'updated_by' => $adminId, // Lưu ID của admin đã cập nhật
        ]);

        return redirect()->route('admin.all.Doctor');
    }

    public function delete_Doctor($id) {
        // Lấy ID của admin đang đăng nhập
        $adminId = Auth::guard('admins')->id();

        $doctor = Doctor::findOrFail($id);
        
        // Lưu vết xóa (optional, có thể lưu vào một bảng log nếu cần)
        // Bạn có thể cập nhật bảng doctor để lưu lại thông tin người xóa
        $doctor->update(['deleted_by' => $adminId]);

        // Xóa bác sĩ
        $doctor->delete();

        return redirect()->route('admin.all.Doctor');
    }
}
