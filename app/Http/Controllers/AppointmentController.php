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
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmation;
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
    
        return response()->json([
            'selectedDate' => $selectedDate,
            'timeSlots' => $timeSlots
        ]);        
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
        $info_patients = DB::table('info_patients')->where('id', $user->user_id)->first();

        if (!$info_patients) {
            return redirect()->back()->with('error', 'Không tìm thấy thông tin bệnh nhân. Vui lòng cập nhật thông tin');
        }

        // Xử lý dữ liệu từ form
        $validated = $request->validate([
            'location_id' => 'required|exists:locations,location_id',
            'specialization_id' => 'required|exists:specialties,specialty_id',
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
            'time_slot' => 'required',
            'reason' => 'nullable|string',
        ]);

        // Kiểm tra xem lịch hẹn trùng lặp đã tồn tại chưa
        $existingAppointment = Enroll::where('patient_id', $info_patients->id)
            ->where('doctor_id', $validated['doctor_id'])
            ->where('location_id', $validated['location_id'])
            ->where('specialty_id', $validated['specialization_id'])
            ->where('date', $validated['date'])
            ->where('time_slot', $validated['time_slot'])
            ->first();

        if ($existingAppointment) {
            return redirect()->route('appointment.create')->with('error', 'Bạn đã đăng ký lịch hẹn này trước đó. Vui lòng chọn thời gian khác.');
        }

        // Lưu dữ liệu vào bảng enrolls
        $enroll = Enroll::create([
            'status' => '0',  // Mặc định là trạng thái chờ
            'total_cost' => $request->total_cost,  // Tổng phí
            'date' => $request->date,
            'time_slot' => $request->time_slot,
            'patient_id' => $info_patients->id,
            'doctor_id' => $validated['doctor_id'],
            'specialty_id' => $validated['specialization_id'],
            'location_id' => $validated['location_id'],
            'reason'  => $validated['reason'],
            'result_pdf' => null,  // Khi tạo lịch hẹn, chưa có kết quả
            'created_at' => Carbon::now('Asia/Ho_Chi_Minh'),
        ]);

        // Tạo mã QR bằng API
        $data = $enroll->id;
        $url = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($data);
        $qrCodeImage = file_get_contents($url);
        $qrCodePath = public_path('qrcodes/qr-code-' . $data . '.png');
        file_put_contents($qrCodePath, $qrCodeImage);

        // Lấy thông tin bệnh nhân
        $patient = DB::table('patients')
            ->join('info_patients', 'patients.user_id', '=', 'info_patients.id')
            ->where('patients.user_id', $user->user_id)
            ->select('patients.email', 'info_patients.HoTen')
            ->first();

        $doctor = DB::table('doctors')
            ->where('id', $request->doctor_id)
            ->first();
        
        $specialty = DB::table('specialties')
            ->where('specialty_id', $request->specialization_id)
            ->first();
        
        $location = DB::table('locations')
            ->where('location_id', $request->location_id)
            ->first();

        // Chuẩn bị dữ liệu để gửi email
        $appointment = [
            'id' => $enroll->id,
            'patient_name' => $patient->HoTen,
            'date' => $request->date,
            'time_slot' => $request->time_slot,
            'specialty' => $specialty->specialty,
            'doctor_name' => $doctor->HoTen,
            'location_name' => $location->location_name,
            'total_cost' => $request->total_cost,
            'email' => $patient->email,
            'qr_code_path' => $qrCodePath,
        ];

        // Gửi email xác nhận với QR code inline
        try {
            Mail::send('pages.emails.appointment_confirmation', $appointment, function ($message) use ($patient, $appointment) {
                $message->to($patient->email)
                    ->subject('Xác nhận lịch hẹn')
                    ->attach($appointment['qr_code_path'], [
                        'as' => 'qrcode.png',
                        'mime' => 'image/png',
                    ])
                    ->embedData(file_get_contents($appointment['qr_code_path']), 'qrcode.png', 'image/png'); // Dùng embedData thay vì embed
            });
        
            // Lưu enroll_id vào session
            session(['enroll_id' => $appointment['id']]);
        
            return redirect()->back()->with('success', 'Đăng ký lịch hẹn thành công! Email xác nhận đã được gửi với mã QR Check-in.');
        } catch (\Exception $e) {
            \Log::error('Error sending appointment confirmation email: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi gửi email xác nhận!');
        }
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
            return redirect()->route('enroll.history')->with('error', 'Lịch khám không tồn tại.');
        }

        // Kiểm tra xem lịch hẹn đã trùng lặp chưa
        $existingAppointment = Enroll::where('patient_id', $appointment->patient_id)
            ->where('doctor_id', $request->doctor_id)
            ->where('location_id', $request->location_id)
            ->where('specialty_id', $request->specialization_id)
            ->where('date', $request->date)
            ->where('time_slot', $request->time_slot)
            ->where('id', '<>', $appointment_id) // Không so sánh với chính lịch hiện tại
            ->where('status', '<>', 2) // Bỏ qua các lịch đã bị hủy
            ->first();

        if ($existingAppointment) {
            return redirect()->route('enroll.history')->with('error', 'Bạn đã có lịch hẹn trùng với lịch này. Vui lòng chọn thời gian khác.');
        }

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
        return redirect()->route('enroll.history')->with('success', 'Cập nhật lịch khám thành công.');
    }

    public function cancel_appointment($id)
    {
        // Lấy thông tin lịch hẹn theo ID
        $appointment = Enroll::find($id);

        // Kiểm tra nếu không tìm thấy lịch hẹn
        if (!$appointment) {
            return redirect()->route('enroll.history')->with('error', 'Không tìm thấy lịch hẹn để hủy.');
        }

         // Kiểm tra nếu lịch hẹn đã bị hủy
        if ($appointment->status == 2) {
            return redirect()->route('enroll.history')->with('error', 'Lịch hẹn này đã bị hủy trước đó.');
        }

        // Kiểm tra nếu lịch hẹn đã thanh toán, không thể hủy
        if ($appointment->status == 1) {
            return redirect()->route('enroll.history')->with('error', 'Lịch hẹn đã được thanh toán, không thể hủy.');
        }

        // Cập nhật trạng thái lịch hẹn thành 2 (đã hủy)
        $appointment->status = 2;
        $appointment->save();

        // Trả về thông báo thành công và chuyển hướng về trang lịch sử
        return redirect()->route('enroll.history')->with('success', 'Lịch hẹn đã được hủy thành công.');
    }

    public function all_appointment(Request $request)
    {
        // Lấy danh sách bác sĩ, địa điểm và chuyên khoa
        $doctors = DB::table('doctors')->get();
        $locations = DB::table('locations')->get();
        $specialties = DB::table('specialties')->get();

        // Lọc các lịch khám
        $query = DB::table('enrolls')
            ->join('info_patients', 'enrolls.patient_id', '=', 'info_patients.id')
            ->join('doctors', 'enrolls.doctor_id', '=', 'doctors.id')
            ->join('locations', 'enrolls.location_id', '=', 'locations.location_id')
            ->join('specialties', 'enrolls.specialty_id', '=', 'specialties.specialty_id')
            ->select(
                'enrolls.*', 
                'info_patients.HoTen as patient_name', 
                'doctors.HoTen as doctor_name',
                'locations.location_name',
                'specialties.specialty',
                'info_patients.sdt as patient_phone'
            );

        // Lọc theo bác sĩ
        if ($request->has('doctor_id') && $request->doctor_id != '') {
            $query->where('enrolls.doctor_id', $request->doctor_id);
        }

        // Lọc theo địa điểm
        if ($request->has('location_id') && $request->location_id != '') {
            $query->where('enrolls.location_id', $request->location_id);
        }

        // Lọc theo chuyên khoa
        if ($request->has('specialty_id') && $request->specialty_id != '') {
            $query->where('enrolls.specialty_id', $request->specialty_id);
        }

        // Lọc theo trạng thái
        if ($request->has('status') && $request->status != '') {
            $query->where('enrolls.status', $request->status);
        }

        // Tìm kiếm theo tên bệnh nhân hoặc số điện thoại
        if ($request->has('search') && $request->search != '') {
            $query->where(function($query) use ($request) {
                $query->where('info_patients.HoTen', 'like', '%'.$request->search.'%')
                    ->orWhere('info_patients.sdt', 'like', '%'.$request->search.'%');
            });
        }

        // Phân trang
        $appointments = $query->paginate(10);

        // Truyền dữ liệu cho view
        return view('admin.appointment.all', compact('appointments', 'doctors', 'locations', 'specialties'));
    }
    
    public function getReceipt($id)
    {
        // Lấy thông tin phiếu đăng ký từ DB
        $appointment = DB::table('enrolls')
            ->join('info_patients', 'enrolls.patient_id', '=', 'info_patients.id')
            ->join('patients', 'enrolls.patient_id', '=', 'patients.user_id')
            ->join('doctors', 'enrolls.doctor_id', '=', 'doctors.id')
            ->join('locations', 'enrolls.location_id', '=', 'locations.location_id')
            ->join('specialties', 'enrolls.specialty_id', '=', 'specialties.specialty_id')
            ->where('enrolls.id', $id)
            ->select(
                'info_patients.HoTen as patient_name',
                'info_patients.sdt as phone',
                'info_patients.NgaySinh as dob',
                'info_patients.GioiTinh as gender',
                'patients.email',
                'doctors.HoTen as doctor_name',
                'specialties.specialty',
                'locations.location_name',
                'enrolls.id',
                'enrolls.date',
                'enrolls.time_slot',
                'enrolls.total_cost',
                'enrolls.reason',
                'enrolls.status'
            )
            ->first();

        // Kiểm tra nếu không tìm thấy
        if (!$appointment) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy phiếu đăng ký với ID này.'
            ], 404);
        }

        // Xử lý giới tính
        $appointment->gender = $appointment->gender == 1 ? 'Nam' : ($appointment->gender == 2 ? 'Nữ' : 'Không xác định');

        // Xử lý trạng thái thanh toán
        switch ($appointment->status) {
            case 0:
                $appointment->status = 'Chưa thanh toán';
                break;
            case 1:
                $appointment->status = 'Đã thanh toán';
                break;
            case 2:
                $appointment->status = 'Đã hủy';
                break;
            default:
                $appointment->status = 'Không xác định';
        }

        // Trả về JSON khi tìm thấy
        return response()->json([
            'success' => true,
            'data' => $appointment
        ]);
    }

    public function admin_edit_appointment($id)
    {
        // Truy vấn thông tin chi tiết cuộc hẹn từ bảng enrolls
        $appointment = DB::table('enrolls')
            ->where('id', $id)  // Lấy thông tin cuộc hẹn dựa trên id được truyền vào
            ->first();
        
        // Nếu không tìm thấy cuộc hẹn, có thể thêm xử lý lỗi ở đây (ví dụ: redirect về trang danh sách cuộc hẹn)
        if (!$appointment) {
            return redirect()->route('admin.appointment.index')->with('error', 'Appointment not found.');
        }
        
        // Lấy thông tin người bệnh (patient) qua patient_id từ bảng enrolls
        $patientInfo = DB::table('info_patients')
            ->where('id', $appointment->patient_id)  // Liên kết với patient_id trong bảng enrolls
            ->first();
    
        // Truy vấn email từ bảng patients thông qua user_id trong bảng patients
        $patientEmail = DB::table('patients')
            ->where('user_id', $patientInfo->id)  // Liên kết với user_id trong bảng patients và id trong bảng info_patients
            ->value('email');  // Lấy giá trị của email
    
        // Lấy thông tin người dùng hiện tại là admin từ guard 'admin'
        $admin = Auth::guard('admins')->user();
        if (!$admin) {
            return redirect()->route('admin.login')->with('error', 'You must be logged in as admin to view this page.');
        }
    
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
        return view('admin.appointment.edit', compact(
            'admin',
            'locations',
            'specialties',
            'doctors',
            'timeslots',
            'patientInfo',
            'appointment',
            'patientEmail'  // Truyền email vào view
        ));
    }
    
    

    public function admin_update_appointment(Request $request, $appointment_id)
    {
        // Lấy thông tin người dùng hiện tại (admin)
        $admin = Auth::guard('admins')->user(); // Lấy thông tin người dùng hiện tại từ guard 'admin'

        // Lấy thông tin lịch khám theo ID
        $appointment = Enroll::find($appointment_id);

        // Nếu không tìm thấy lịch khám, trả về lỗi
        if (!$appointment) {
            return redirect()->route('admin.appointment.all')->with('error', 'Lịch khám không tồn tại.');
        }

        // Kiểm tra xem lịch hẹn đã trùng lặp chưa
        $existingAppointment = Enroll::where('patient_id', $appointment->patient_id)
            ->where('doctor_id', $request->doctor_id)
            ->where('location_id', $request->location_id)
            ->where('specialty_id', $request->specialization_id)
            ->where('date', $request->date)
            ->where('time_slot', $request->time_slot)
            ->where('id', '<>', $appointment_id) // Không so sánh với chính lịch hiện tại
            ->where('status', '<>', 2) // Bỏ qua các lịch đã bị hủy
            ->first();

        if ($existingAppointment) {
            return redirect()->route('admin.appointment.all')->with('error', 'Lịch hẹn trùng với lịch khác. Vui lòng chọn thời gian khác.');
        }

        // Cập nhật thông tin lịch khám
        $appointment->update([
            'location_id' => $request->location_id,
            'specialty_id' => $request->specialization_id,
            'doctor_id' => $request->doctor_id,
            'reason' => $request->reason,
            'date' => $request->date,
            'time_slot' => $request->time_slot,
            'total_cost' => $request->total_cost,
            'updated_at' => Carbon::now('Asia/Ho_Chi_Minh'),
            'updated_by_admin' => $admin->id, // Cập nhật thông tin người dùng (admin) đã sửa
        ]);

        // Trả về kết quả sau khi cập nhật
        return redirect()->route('admin.appointment.all')->with('success', 'Cập nhật lịch khám thành công.');
    }

    public function confirm_payment($id)
    {
        $appointment = Enroll::find($id);

        if ($appointment) {
            // Kiểm tra nếu lịch hẹn chưa thanh toán
            if ($appointment->status == 0) {
                $appointment->status = 1; // Cập nhật trạng thái là "Đã thanh toán"
                $appointment->save();

                return redirect()->route('admin.appointment.all')->with('success', 'Thanh toán đã được xác nhận thành công.');
            }
        }

        return redirect()->route('admin.appointment.all')->with('error', 'Không tìm thấy lịch hẹn hoặc lịch đã thanh toán.');
    }

    public function admin_cancel_appointment(Request $request, $id)
    {
        // Tìm lịch hẹn theo ID
        $appointment = DB::table('enrolls')->where('id', $id)->first();
    
        // Kiểm tra nếu lịch hẹn không tồn tại
        if (!$appointment) {
            return redirect()->back()->with('error', 'Lịch hẹn không tồn tại.');
        }

        // Kiểm tra nếu lịch hẹn đã bị hủy
        if ($appointment->status == 2) {
            return redirect()->back()->with('error', 'Lịch hẹn này đã bị hủy trước đó.');
        }
    
        // Lấy ngày giờ hiện tại
        $now = Carbon::now();
    
        // Trích xuất thời gian bắt đầu từ `time_slot`
        // Giả sử time_slot có định dạng "HH:mm - HH:mm"
        $timeSlotParts = explode(' - ', $appointment->time_slot);
        $startTime = $appointment->date . ' ' . $timeSlotParts[0]; // Ghép ngày với giờ bắt đầu
    
        // Tạo Carbon từ thời gian bắt đầu
        $appointmentStartTime = Carbon::parse($startTime);
    
        // Kiểm tra nếu còn ít hơn 48 giờ so với giờ bắt đầu
        if ($now->diffInHours($appointmentStartTime, false) < 48) {
            return redirect()->back()->with('error', 'Chỉ có thể hủy lịch hẹn trước 48 giờ.');
        }
    
        // Cập nhật trạng thái lịch hẹn thành "Đã hủy" (status = 2)
        DB::table('enrolls')->where('id', $id)->update([
            'status' => 2,
            'updated_at' => $now, // Cập nhật thời gian sửa đổi
        ]);
    
        // Chuyển hướng về trang trước với thông báo thành công
        return redirect()->back()->with('success', 'Lịch hẹn đã được hủy thành công.');
    } 
}
