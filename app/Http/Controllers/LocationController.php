<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    // Hiển thị danh sách các địa điểm
    public function all_location()
    {
        $adminUser = Auth::guard('admins')->user();
        $all_location = DB::table('locations')->orderBy('location_id', 'desc')->get();

        return view('admin.location.all_location', [
            'user' => $adminUser,
            'all_location' => $all_location
        ]);
    }

    // Hiển thị form thêm mới địa điểm
    public function add_location()
    {
        $adminUser = Auth::guard('admins')->user();
        return view('admin.location.add_location', ['user' => $adminUser]);
    }

    // Lưu thông tin địa điểm vào database
    public function save_location(Request $request)
    {
        // Lấy ID admin từ session
        $adminId = session('admin_id');

        // Validate dữ liệu đầu vào
        $validatedData = $request->validate([
            'location_name' => 'required|string|max:255',
            'location_address' => 'required|string|max:255',
        ]);

        // Kiểm tra trùng tên hoặc địa chỉ không phân biệt hoa thường
        $existingLocation = Location::whereRaw('LOWER(location_name) = ?', [strtolower($request->location_name)])
            ->orWhereRaw('LOWER(location_address) = ?', [strtolower($request->location_address)])
            ->first();

        if ($existingLocation) {
            return back()->withErrors(['message' => 'Tên hoặc địa chỉ địa điểm đã tồn tại!'])->withInput();
        }

        // Tạo mới địa điểm
        $location = new Location();
        $location->location_name = $request->location_name;
        $location->location_address = $request->location_address;
        $location->created_by = $adminId; // Thêm ID người tạo
        $location->save();

        // Redirect sau khi lưu thành công
        return redirect()->route('admin.all.locations')->with('success', 'Địa điểm đã được thêm thành công!');
    }

    // Hiển thị form chỉnh sửa địa điểm
    public function edit_location($id)
    {
        $adminUser = Auth::guard('admins')->user();

        // Fetch the location by its ID
        $location = Location::where('location_id', $id)->first();

        if (!$location) {
            return back()->withErrors(['message' => 'Không tìm thấy địa điểm']);
        }

        // Return the edit view
        return view('admin.location.edit_location', [
            'user' => $adminUser,
            'location' => $location
        ]);
    }

    // Cập nhật thông tin địa điểm
    public function update_location(Request $request, $id)
    {
        // Validate dữ liệu đầu vào
        $validatedData = $request->validate([
            'location_name' => 'required|string|max:255',
            'location_address' => 'required|string|max:255',
        ]);

        // Kiểm tra trùng tên hoặc địa chỉ không phân biệt hoa thường
        $existingLocation = Location::where('location_id', '!=', $id)
            ->where(function ($query) use ($request) {
                $query->whereRaw('LOWER(location_name) = ?', [strtolower($request->location_name)])
                    ->orWhereRaw('LOWER(location_address) = ?', [strtolower($request->location_address)]);
            })
            ->first();

        if ($existingLocation) {
            return back()->withErrors(['message' => 'Tên hoặc địa chỉ địa điểm đã tồn tại!'])->withInput();
        }

        // Cập nhật thông tin địa điểm
        DB::table('locations')
            ->where('location_id', $id)
            ->update([
                'location_name' => $request->location_name,
                'location_address' => $request->location_address,
                'updated_at' => now(),
            ]);

        // Thông báo cập nhật thành công
        session()->put('message', 'Cập nhật thông tin địa điểm thành công');

        // Chuyển hướng về trang danh sách
        return redirect()->route('admin.all.locations');
    }

    // Xóa địa điểm
    public function delete_location($location_id)
    {
        // Fetch the record to be deleted
        $location = DB::table('locations')->where('location_id', $location_id)->first();

        // Check if the record exists
        if (!$location) {
            return back()->withErrors(['message' => 'Không tìm thấy địa điểm']);
        }

        // Get the ID of the current authenticated admin
        $adminId = Auth::guard('admins')->id();

        // Perform the actual deletion
        DB::table('locations')->where('location_id', $location_id)->delete();

        // Store a success message in the session
        session()->put('message', 'Xóa địa điểm thành công bởi admin ID: ' . $adminId);

        // Redirect to the locations list
        return redirect()->route('admin.all.locations');
    }
}
