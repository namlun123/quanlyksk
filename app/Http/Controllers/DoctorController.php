<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Chuyenkhoa; // Đúng với model của bạn
use App\Models\Location;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function all_Doctor() {
        $doctors = Doctor::with(['specialty', 'location'])->get(); // Lấy danh sách bác sĩ kèm chuyên khoa và địa điểm
        return view('admin.doctor.all_Doctor', compact('doctors'));
    }

    
    public function add_Doctor() {
        $specialties = Chuyenkhoa::all(); // Đảm bảo Model được sử dụng đúng
        $locations = Location::all();    // Lấy danh sách địa điểm
        return view('admin.doctor.add_Doctor', compact('specialties', 'locations'));
    }

    public function save_Doctor(Request $request) {
        $request->validate([
            'HoTen' => 'required',
            'ChucVu' => 'required',
            'PhiCoBan' => 'required|numeric',
            'specialty_id' => 'required|exists:chuyenkhoas,specialty_id', // Kiểm tra specialty_id có tồn tại trong bảng Chuyenkhoa
            'location_id' => 'required|exists:locations,location_id', // Kiểm tra location_id có tồn tại trong bảng Location
        ]);
    
        Doctor::create([
            'HoTen' => $request->HoTen,
            'ChucVu' => $request->ChucVu,
            'PhiCoBan' => $request->PhiCoBan,
            'specialty_id' => $request->specialty_id,
            'location_id' => $request->location_id,
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
        $doctor->update($request->all());
        return redirect()->route('admin.all.Doctor');
    }

    public function delete_Doctor($id) {
        Doctor::destroy($id);
        return redirect()->route('admin.all.Doctor');
    }
}
