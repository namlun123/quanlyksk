<?php

namespace App\Http\Controllers;
use App\Models\Enroll;
use App\Models\Benhnhan;
use App\Models\TKbenhnhan;
use App\Models\Doctor;
use App\Models\Location;
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
        // Xử lý lọc theo khoảng thời gian nếu có
        $startDate = $request->get('start_date', now()->startOfMonth());
        $endDate = $request->get('end_date', now()->endOfMonth());
        $locationId = $request->get('location_id', null);
        $locations = Location::all();
        
            // Truy vấn doanh thu theo chi nhánh và khoảng thời gian
            $revenueByLocation = DB::table('enrolls')
                ->join('locations', 'enrolls.location_id', '=', 'locations.location_id')
                ->select('locations.location_name', 'locations.location_id', DB::raw('SUM(enrolls.total_cost) as total_revenue_locations'))
                ->where('enrolls.status', 1)
                ->whereBetween('enrolls.date', [$startDate, $endDate])
                // Lọc theo location_id nếu có giá trị
                ->when($locationId, function ($query) use ($locationId) {
                    return $query->where('enrolls.location_id', $locationId);
                })
                ->groupBy('locations.location_name', 'locations.location_id')
                ->get();
        
           // Lấy doanh thu tổng hợp của các chi nhánh trong khoảng thời gian
        $revenueByLocation_time = DB::table('enrolls')
        ->join('locations', 'enrolls.location_id', '=', 'locations.location_id')
        ->select('locations.location_name', 'locations.location_id', DB::raw('SUM(enrolls.total_cost) as total_revenue_locations'))
        ->where('enrolls.status', 1)
        ->whereBetween('enrolls.date', [$startDate, $endDate])
        ->groupBy('locations.location_name', 'locations.location_id')
        ->get();
        
        // Doanh thu theo chuyên khoa (specialties)
        $revenueBySpecialty = DB::table('enrolls')
            ->join('specialties', 'enrolls.specialty_id', '=', 'specialties.specialty_id')
            ->select('specialties.specialty', DB::raw('SUM(enrolls.total_cost) as total_revenue_specialties'))
            ->where('enrolls.status', 1) // Chỉ tính khi status = 1 (đã thanh toán)
            ->whereBetween('enrolls.date', [$startDate, $endDate])
            ->groupBy('specialties.specialty')
            ->get();
    
        // Số lượng đăng ký khám trong tháng
        $registrationsByMonth = DB::table('enrolls')
            ->select(DB::raw('MONTH(date) as month'), DB::raw('COUNT(id) as total_registrations'))
            ->whereBetween('date', [$startDate, $endDate])
            ->groupBy(DB::raw('MONTH(date)'))
            ->get();
    
        // Tổng doanh thu từ enrolls (chỉ lọc theo thời gian và status=1)
        $totalRevenue = DB::table('enrolls')
            ->select(DB::raw('SUM(total_cost) as total_revenue'))
            ->where('status', 1) // Chỉ tính khi status = 1 (đã thanh toán)
            ->whereBetween('date', [$startDate, $endDate])
            ->first(); // Chỉ lấy 1 kết quả duy nhất
                
        return view('admin.dashboard', compact(
            'revenueByLocation',
            'revenueBySpecialty',
            'registrationsByMonth',
            'startDate',
            'endDate',
            'locations',
            'totalRevenue', // Truyền tổng doanh thu vào view
           'revenueByLocation_time' // Truyền giá trị doanh thu vào view
        ));
    }
    // public function updateAdmin(Request $request)
    // {
    //     // Kiểm tra người dùng đã đăng nhập
    //     if (!auth()->check()) {
    //         return redirect()->route('admin_login')->with('error', 'Bạn cần đăng nhập để thực hiện hành động này.');
    //     }
    
    //     // Lấy tài khoản đang đăng nhập
    //     $user = auth()->user();
    //     $admin_id = $user->admin_id;
    
    //     // Kiểm tra nếu tài khoản không có admin_id
    //     if (!$admin_id) {
    //         return redirect()->back()->with('error', 'Tài khoản không có quyền cập nhật thông tin admin.');
    //     }
    
    //     // Validate dữ liệu từ form
    //     $validatedData = $request->validate([
    //         'hoten' => 'required|string|max:255',
    //         'ngaysinh' => 'required|date|before:today',
    //         'sdt' => 'required|string|digits:10',
    //     ]);
    
    //     // Kiểm tra số điện thoại có tồn tại trong DB trừ ID hiện tại
    //     $existingSDT = DB::table('info_admins')->where('SDT', $request->sdt)->where('id', '!=', $admin_id)->exists();
    
    //     if ($existingSDT) {
    //         return back()->withInput()->withErrors(['sdt' => 'Số điện thoại này đã tồn tại']);
    //     }
    
        // Cập nhật thông tin admin
    //     DB::table('info_admins')->where('id', $admin_id)->update([
    //         'HoTen' => $validatedData['hoten'],
    //         'NgaySinh' => $validatedData['ngaysinh'],
    //         'SDT' => $validatedData['sdt'],
    //         'updated_at' => now(),
    //     ]);
    
    //     // Thông báo thành công và chuyển hướng
    //     session()->put('message', 'Cập nhật thông tin admin thành công');
    //     return redirect()->route('admin.all.admins')->with('success', 'Cập nhật thông tin thành công!');
    // }
    
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
