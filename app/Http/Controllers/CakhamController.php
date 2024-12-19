<?php

namespace App\Http\Controllers;


use App\Models\Cakham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class CakhamController extends Controller
{
    public function all_cakham() {
        $adminUser = Auth::guard('admins')->user();
        $all_cakham = DB::table('cakham')->orderBy('cakham_id', 'desc')->get();
        // return view('admin.all_cakham')->with('all_cakham', $all_cakham)->with('adminUser', $adminUser);
        return view('admin.cakham.all_cakham', ['user'=>$adminUser], ['all_cakham'=>$all_cakham]);
    }


    public function add_cakham(Request $request) {
        $adminUser = Auth::guard('admins')->user();
        
        // Lấy danh sách tất cả các chi nhánh
        $all_locations = DB::table('locations')->get();
        
        // Kiểm tra nếu có chi nhánh được chọn và lấy danh sách bác sĩ tương ứng
        $all_doctors = [];
        if ($request->has('location_id')) {
            $location_id = $request->input('location_id');
            $all_doctors = DB::table('doctors')->where('location_id', $location_id)->get();
        }
    
        return view('admin.cakham.add_cakham', [
            'user' => $adminUser,
            'all_locations' => $all_locations,
            'all_doctors' => $all_doctors,  // Truyền danh sách bác sĩ vào view
        ]);
    }
    
    public function displaySchedule(Request $request) { 
    $adminUser = Auth::guard('admins')->user();
    
    // Lấy thông tin chi nhánh, bác sĩ và ngày từ request
    $location_id = $request->input('location_id');
    $doctor_id = $request->input('doctor_id');
    $date = $request->input('date');
    
    // Lấy lịch khám từ cơ sở dữ liệu dựa trên chi nhánh, bác sĩ và ngày
    $schedule = DB::table('cakham')
        ->where('doctor_id', $doctor_id)
        ->where('location_id', $location_id)
        ->whereDate('date', $date)
        ->get();
    
    // Trả về view với thông tin lịch khám
    return view('admin.cakham.add_cakham', [
        'user' => $adminUser,
        'all_locations' => DB::table('locations')->get(),
        'all_doctors' => DB::table('doctors')->where('location_id', $location_id)->get(),
        'schedule' => $schedule,  // Truyền lịch khám vào view
    ]);
}

public function save_cakham(Request $request) {
    $adminUser = Auth::guard('admins')->user();
    $adminId = session('admin_id');
    
    // Validation cho dữ liệu nhập
    $request->validate([
        'date' => 'required|date',
        'time_start' => 'required|date_format:H:i',
        'time_finish' => 'required|date_format:H:i|after:time_start',
        'total_time' => 'required|numeric',
        'extra_cost' => 'nullable|numeric',
        'doctor_id' => 'required|exists:doctors,id',
        'location_id' => 'required|exists:locations,location_id',
    ], [
        'time_finish.after' => 'Thời gian kết thúc phải lớn hơn thời gian bắt đầu.',
    ]);
    
    // Lấy dữ liệu từ request và chuẩn bị cho việc lưu vào DB
    $data = [
        'date' => $request->date, // Ngày tháng cụ thể
        'time_start' => $request->time_start, // Thời gian bắt đầu
        'time_finish' => $request->time_finish, // Thời gian kết thúc
        'total_time' => $request->total_time, // Tổng thời gian
        'extra_cost' => $request->extra_cost, // Chi phí phát sinh
        'doctor_id' => $request->doctor_id, // Mã bác sĩ
        'location_id' => $request->location_id, // Mã địa điểm
        'created_at' => Carbon::now('Asia/Ho_Chi_Minh'), // Thời gian tạo
    ];
    
    // Kiểm tra trùng lặp thời gian khám
    $overlap = DB::table('cakham')
    ->where('doctor_id', $data['doctor_id'])
    ->where('date', $data['date'])
    ->where(function ($query) use ($data) {
        $query->whereBetween('time_start', [$data['time_start'], $data['time_finish']]) 
              ->orWhereBetween('time_finish', [$data['time_start'], $data['time_finish']])
              ->orWhere(function ($subQuery) use ($data) {
                  $subQuery->where('time_start', '<=', $data['time_start'])
                           ->where('time_finish', '>=', $data['time_finish']);
              });
    })
    ->first();

    if ($overlap) {
        // Trả về lỗi nếu phát hiện trùng thời gian và giữ lại dữ liệu đã nhập
        return Redirect::to('admin/add-cakham') // Đảm bảo route này đúng tên của route "add-cakham"
            ->withErrors([
                'time_start' => 'Giờ khám đã tồn tại từ ' . $overlap->time_start . ' đến ' . $overlap->time_finish . ' cho bác sĩ này.'
            ]);
    }

    // Nếu không trùng, lưu ca khám
    DB::table('cakham')->insert($data);
    Session()->put('message', 'Thêm ca khám thành công');
    return Redirect::to('admin/all-cakham');
}

    public function get_doctors_by_location(Request $request)
    {
        if ($request->has('location_id')) {
            $location_id = $request->input('location_id');
            $doctors = DB::table('doctors')->where('location_id', $location_id)->get();
            return response()->json($doctors);
        }
    
        return response()->json(['error' => 'Không có chi nhánh nào được chọn.'], 400);
    }
        

    public function edit_cakham($cakham_id) {
        $adminUser = Auth::guard('admins')->user();
        $cakham = DB::table('cakham')->where('cakham_id', $cakham_id)->first();
    
        // Lấy thông tin chi nhánh của ca khám
        $currentLocationId = $cakham->location_id;
    
        // Lấy tất cả chi nhánh
        $all_locations = DB::table('locations')->get();
    
        // Lấy danh sách bác sĩ thuộc chi nhánh hiện tại
        $all_doctors = DB::table('doctors')
            ->where('location_id', $currentLocationId)
            ->get();
    
        return view('admin.cakham.edit_cakham', [
            'user' => $adminUser,
            'cakham' => $cakham,
            'all_doctors' => $all_doctors,
            'all_locations' => $all_locations,
        ]);
    }
    
    public function update_cakham(Request $request, $cakham_id) {
        $adminUser = Auth::guard('admins')->user();
    
        // Validate the input data
        $data = $request->validate([
            'date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    // Lấy ngày hôm nay
                    $today = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
                
                    // Kiểm tra nếu ngày khám nhỏ hơn ngày hôm nay
                    if ($value < $today) {
                        $fail('Ngày khám phải là ngày hôm nay trở đi.');
                    }
                }
                
            ],
            'time_start' => 'required',
            'time_finish' => 'required',
            'total_time' => 'required|numeric',
            'extra_cost' => 'nullable|numeric',
            'doctor_id' => 'required|exists:doctors,id',  // Ensure doctor exists
            'location_id' => 'required|exists:locations,location_id',  // Ensure location exists
        ], [
            'date.required' => 'Phải nhập ngày khám',
            'time_start.required' => 'Phải nhập giờ bắt đầu',
            'time_finish.required' => 'Phải nhập giờ kết thúc',
            'total_time.required' => 'Phải nhập thời gian tổng',
            'doctor_id.required' => 'Phải chọn bác sĩ',
            'location_id.required' => 'Phải chọn địa điểm khám',
        ]);
    
        // Prepare the data to be updated
        $adminId = session('admin_id');
        $dataToUpdate = [
            'date' => $request->date,
            'time_start' => $request->time_start,
            'time_finish' => $request->time_finish,
            'total_time' => $request->total_time,
            'extra_cost' => $request->extra_cost ?? 0,
            'doctor_id' => $request->doctor_id,
            'location_id' => $request->location_id,
        ];
    
        // Update the cakham record in the database
        DB::table('cakham')->where('cakham_id', $cakham_id)->update($dataToUpdate);
    
        // Set success message and redirect
        Session()->put('message', 'Sửa ca khám thành công');
        return Redirect::to('admin/all-cakham');
    }
    
    public function delete_cakham($cakham_id) {
        $adminUser = Auth::guard('admins')->user();
        $cakham = DB::table('cakham')->where('cakham_id', $cakham_id)->first();
        DB::table('cakham')->where('cakham_id', $cakham_id)->delete();
    
        // Set success message and redirect
        Session()->put('message', 'Xóa ca khám thành công');
        return Redirect::to('admin/all-cakham');
    }
    
}
