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

class AppointmentController extends Controller
{
    // Hiển thị form tạo lịch hẹn
    public function create_appointment()
    {
        // Lấy thông tin người dùng hiện tại từ bảng 'patients'
        $user = Auth::guard('patients')->user();  // Lấy thông tin người dùng hiện tại từ guard 'patients'
        $id = $user->id;

        // Truy vấn thông tin chi tiết người bệnh từ bảng 'infor_patients' bằng cách sử dụng user_id
        $patientInfo = DB::table('info_patients')
            ->where('id', $user->user_id)  // Liên kết bảng 'patients' với bảng 'infor_patients' thông qua user_id
            ->first();

        // Truy vấn tất cả các bệnh viện/phòng khám từ CSDL
        $locations = DB::table('locations')->get();

        // Truy vấn tất cả các chuyên khoa từ CSDL
        $specialties = DB::table('specialties')->get();

        // Truy vấn tất cả các bác sĩ từ CSDL
        $doctors = DB::table('doctors')->get();

        // Truy vấn thời gian khám từ bảng cakham cho ngày hôm nay trở đi
        $today = date('Y-m-d');  // Lấy ngày hôm nay
        $timeslots = DB::table('cakham')
            ->where('date', '>=', $today)
            ->orderBy('date')  // Sắp xếp theo ngày
            ->get();

        // Trả về view với dữ liệu
        return view('pages.appointment.create', compact('user', 'locations', 'specialties', 'id', 'doctors', 'timeslots', 'patientInfo'));
    }

    // Phương thức để lấy danh sách bác sĩ theo địa điểm và chuyên khoa
    public function getDoctors($locationId, $specializationId)
    {
        // Truy vấn các bác sĩ từ CSDL dựa trên location_id và specialization_id
        $doctors = DB::table('doctors')
            ->where('location_id', $locationId)
            ->where('specialty_id', $specializationId)
            ->get();

        // Trả về dữ liệu dưới dạng JSON
        return response()->json($doctors);
    }  
    
    public function getTimeSlots(Request $request, $locationId, $doctorId, $selectedDate)
    {
        // Lấy thông tin bác sĩ từ bảng doctors
        $doctor = DB::table('doctors')->where('id', $doctorId)->first();
        if (!$doctor) {
            return response()->json(['error' => 'Không tìm thấy bác sĩ.'], 404);
        }
    
        // Lấy tất cả các ca khám trong ngày cho bác sĩ tại địa điểm và ngày đã chọn
        $caKhams = DB::table('cakham')
            ->where('doctor_id', $doctorId)
            ->where('location_id', $locationId)
            ->whereDate('date', $selectedDate)
            ->get();
    
        if ($caKhams->isEmpty()) {
            return response()->json(['error' => 'Không tìm thấy lịch khám hợp lệ.'], 404);
        }
    
        $timeSlots = [];
        foreach ($caKhams as $caKham) {
            // Chia nhỏ ca khám thành các khung giờ
            $slots = $this->splitTimeSlots($caKham->time_start, $caKham->time_finish, $caKham->total_time);
            
            // Lấy các khung giờ đã đăng ký trong bảng enrolls
            $enrolledSlots = DB::table('enrolls')
                ->where('doctor_id', $doctorId)
                ->where('location_id', $locationId)
                ->where('date', $selectedDate)
                ->where('status', 1)
                ->pluck('time_slot')
                ->toArray();
    
            // Tính phí khám cơ bản và phí ngoài giờ
            $phiCoBan = $doctor->PhiCoBan;
            $extraCost = $caKham->extra_cost ?? 0;
            $totalCost = $phiCoBan + $extraCost;
    
            // Gắn trạng thái và tổng tiền cho từng khung giờ
            foreach ($slots as &$slot) {
                $fullSlot = $slot['timeStart'] . ' - ' . $slot['timeFinish'];
                $slot['status'] = in_array($fullSlot, $enrolledSlots) ? 'booked' : 'available';
                $slot['phi_co_ban'] = $phiCoBan;
                $slot['extra_cost'] = $extraCost;
                $slot['total_cost'] = $totalCost;
            }
    
            // Thêm các khung giờ vào danh sách chung
            $timeSlots = array_merge($timeSlots, $slots);
        }
    
        return response()->json($timeSlots);
    }
    
    
    
    
private function splitTimeSlots($timeStart, $timeFinish, $totalTime)
{
    $startTime = strtotime($timeStart);
    $endTime = strtotime($timeFinish);
    $timeSlots = [];

    while ($startTime < $endTime) {
        $slotEndTime = $startTime + $totalTime * 60; // Tính thời gian kết thúc của khung giờ nhỏ
        if ($slotEndTime > $endTime) {
            break; // Dừng khi thời gian kết thúc vượt quá giờ làm việc
        }

        $timeSlots[] = [
            'timeStart' => date('H:i', $startTime),
            'timeFinish' => date('H:i', $slotEndTime),
        ];

        $startTime = $slotEndTime; // Cập nhật thời gian bắt đầu cho lần tiếp theo
    }

    return $timeSlots;
}

private function isTimeOverlap($slotStart, $slotEnd, $enrollStart, $totalTime)
{
    $enrollEnd = strtotime($enrollStart) + $totalTime * 60; // Tính thời gian kết thúc của lịch đăng ký
    $slotStartTimestamp = strtotime($slotStart);
    $slotEndTimestamp = strtotime($slotEnd);

    return ($slotStartTimestamp < $enrollEnd && $slotEndTimestamp > strtotime($enrollStart));
}


    // Xử lý lưu thông tin lịch hẹn
    public function store_appointment(Request $request, $id)
    {
        // Lấy thông tin người dùng hiện tại
        $user = Auth::guard('patients')->user();

        // Xử lý dữ liệu từ form
        $validated = $request->validate([
            'location_id' => 'required|exists:locations,location_id',
            'specialization_id' => 'required|exists:specialties,specialty_id',
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
            'time_slot' => 'required',
            'reason' => 'nullable|string',
        ]);

        // Lưu dữ liệu vào bảng enrolls
        $enroll = Enroll::create([
            'status' => '0',  // Mặc định là trạng thái chờ
            'total_cost' => $request->total_cost,  // Tổng phí
            'date' => $request->date,
            'time_slot' => $request->time_slot,
            'patient_id' => $user->id,
            'doctor_id' => $validated['doctor_id'],
            'specialty_id' => $validated['specialization_id'],
            'location_id' => $validated['location_id'],
            'reason'  => $validated['reason'],
            'ketqua_id' => null,  // Khi tạo lịch hẹn, chưa có kết quả
            'created_at' => Carbon::now('Asia/Ho_Chi_Minh'),
        ]);

        // Chuyển hướng tới trang thanh toán và truyền thông tin cần thiết
        return redirect()
        ->back()
        ->with('success', 'Đăng ký lịch hẹn thành công!')
        ->with('enroll_id', $enroll->id);
    }
    public function edit_appointment($id)
    {
        // Lấy thông tin người dùng hiện tại từ bảng 'patients'
        $user = Auth::guard('patients')->user();  // Lấy thông tin người dùng hiện tại từ guard 'patients'
        $userId = $user->id;  // Lưu trữ id của người dùng hiện tại

        // Truy vấn thông tin chi tiết người bệnh từ bảng 'infor_patients' bằng cách sử dụng user_id
        $patientInfo = DB::table('info_patients')
            ->where('id', $user->user_id)  // Liên kết bảng 'patients' với bảng 'infor_patients' thông qua user_id
            ->first();

        // Truy vấn tất cả các bệnh viện/phòng khám từ CSDL
        $locations = DB::table('locations')->get();

        // Truy vấn tất cả các chuyên khoa từ CSDL
        $specialties = DB::table('specialties')->get();

        // Truy vấn tất cả các bác sĩ từ CSDL
        $doctors = DB::table('doctors')->get();

        // Truy vấn thời gian khám từ bảng cakham cho ngày hôm nay trở đi
        $today = date('Y-m-d');  // Lấy ngày hôm nay
        $timeslots = DB::table('cakham')
            ->where('date', '>=', $today)
            ->orderBy('date')  // Sắp xếp theo ngày
            ->get();

        // Truy vấn thông tin chi tiết cuộc hẹn từ bảng enrolls
        $appointment = DB::table('enrolls')
            ->where('id', $id)  // Lấy thông tin cuộc hẹn dựa trên id được truyền vào
            ->first();

        // Trả về view với dữ liệu
        return view('pages.appointment.edit', compact(
            'user',
            'locations',
            'specialties',
            'userId',
            'doctors',
            'timeslots',
            'patientInfo',
            'appointment'
        ));
    }

    public function update_appointment(Request $request, $appointment_id)
{
    // Lấy thông tin người dùng hiện tại từ bảng 'patients'
    $user = Auth::guard('patients')->user();  // Lấy thông tin người dùng hiện tại từ guard 'patients'
    $id = $user->id; // Lấy ID người dùng hiện tại

    // Lấy thông tin lịch khám theo ID
    $appointment = Enroll::find($appointment_id);

    // Nếu không tìm thấy lịch khám, trả về lỗi
    if (!$appointment) {
        return redirect()->route('appointment.create')->with('error', 'Lịch khám không tồn tại.');
    }

    // Kiểm tra và in thông tin lịch khám trước khi cập nhật
    /*dd([
        'location_id' => $request->location_id,
        'specialization_id' => $request->specialization_id,
        'doctor_id' => $request->doctor_id,
        'reason' => $request->reason,
        'date' => $request->date,
        'time_slot' => $request->time_slot,
        'total_cost' => $request->total_cost,
        'updated_by_user' => $id,
        'updateAt' = Carbon::now('Asia/Ho_Chi_Minh');
    ]);*/

    // Cập nhật thông tin lịch khám
    $appointment->update([
        'location_id' => $request->location_id,
        'specialization_id' => $request->specialization_id,
        'doctor_id' => $request->doctor_id,
        'reason' => $request->reason,
        'date' => $request->date,
        'time_slot' => $request->time_slot,
        'total_cost' => $request->total_cost,
        'updated_at' => Carbon::now('Asia/Ho_Chi_Minh'),
        'updated_by_user' => $id, // Cập nhật thông tin người dùng đã sửa
    ]);

    // Trả về kết quả sau khi cập nhật
    return redirect()->route('appointment.create')->with('success', 'Cập nhật lịch khám thành công.');
}

}
