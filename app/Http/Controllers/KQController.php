<?php

namespace App\Http\Controllers;

use App\Models\Benhnhan;
use App\Models\TKbenhnhan;
use App\Models\KQ;
use App\Models\LoaiXN;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use App\Models\Enroll;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage; // Thêm Facade này vào
use PDF;
class KQController extends Controller
{
    public function get_thong_tin_bn($id) {
    
        $bn = DB::table('info_patients')->where('id', $id)->first();
        $khs = DB::table('patients')->where('user_id', $bn->id)->first(); // liên kết qua user_id của patients tới info_patients
        $hoso = DB::table('enrolls')
        ->join('patients', 'enrolls.patient_id', '=', 'patients.user_id')
        ->where('patients.user_id', $bn->id)
        ->select('enrolls.id as hoso_id') // chỉ lấy cột id của enrolls
        ->get();
        $data = [
            'bn' => $bn,
            'kh' => $khs,
            'hs' => $hoso
        ];

        // Trả về dữ liệu dưới dạng JSON
        return response()->json($data);
    }
    public function store(Request $request) {
        // Validate dữ liệu từ request
        $validatedData = $request->validate([
            'xetnghiem_id_hidden' => 'required|integer',   // Mã xét nghiệm (xn_id)
            'ketqua_hidden' => 'required|string',    // Kết quả xét nghiệm
            'hs' => 'required|integer'  // Mã hồ sơ (hoso_id)
        ]);
    
        try {
            // Kiểm tra xem kết quả đã tồn tại cho hồ sơ này và mã xét nghiệm chưa
            $existingKetQua = DB::table('ketqua')
                ->where('hoso_id', $validatedData['hs'])
                ->where('xn_id', $validatedData['xetnghiem_id_hidden'])
                ->first(); // Lấy kết quả hiện có nếu tồn tại
    
            if ($existingKetQua) {
                // Nếu đã tồn tại kết quả cho mã xét nghiệm này, trả về thông báo lỗi
                return redirect()->back()->with('error', 'Kết quả xét nghiệm này đã tồn tại cho hồ sơ này');
            } else {
                // Thêm mới kết quả
                DB::table('ketqua')->insert([
                    'xn_id' => $validatedData['xetnghiem_id_hidden'], // Loại xét nghiệm
                    'ketqua' => $validatedData['ketqua_hidden'],   // Kết quả xét nghiệm
                    'hoso_id' => $validatedData['hs'] // Khóa ngoại hoso_id
                ]);
    
                // Trả về thông báo thành công với mã hóa UTF-8
                return redirect()->back()->with('success', 'Dữ liệu đã được lưu thành công!');
            }
        } catch (\Exception $e) {
            // Trả về lỗi nếu có
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    
        return redirect()->back();
    }
    
    
    public function getTenXetNghiem($id)
    {
        $xetnghiem = LoaiXN::find($id);
        // DB::table('loaixn')->where('xetnghiem_id', $id)->first();        
        $data = [ 'xetnghiem' =>$xetnghiem];
        return response()->json($data);
    }
    public function add_kq() {
        $xetnghiem = LoaiXN::all();
        $adminUser = Auth::guard('admins')->user();
        return view('admin.ketqua.add_kq', [
            'user' => $adminUser,
            'xetnghiem' => $xetnghiem // Truyền biến xetnghiem vào view
        ]);
    }
    public function all_kq() {
        $adminUser = Auth::guard('admins')->user();
        $all_kq =  DB::table('info_patients')
        ->join('patients', 'info_patients.id', '=', 'patients.user_id')
        ->join('enrolls', 'patients.user_id', '=', 'enrolls.patient_id')
        ->join('ketqua', 'enrolls.id', '=', 'ketqua.hoso_id') // Join bảng ketqua
        ->select('enrolls.*', 'info_patients.HoTen as ht', 'patients.user_id as mabn', 'enrolls.id as mahs', 'ketqua.xn_id') // Lấy tất cả các cột từ 3 bảng
        ->whereNotNull('ketqua.xn_id') // Chỉ lấy hồ sơ có kết quả xét nghiệm
        ->orderBy('enrolls.id', 'asc') // Sắp xếp theo ID giảm dần
        ->get(); // Lấy tất cả các dữ liệu
        return view('admin.ketqua.all_kq', ['user'=>$adminUser], ['all_kq'=>$all_kq]);
    }
   
    public function edit_kq($id) {
        $adminUser = Auth::guard('admins')->user();
        $kq = DB::table('ketqua')
        ->join('loaixn', 'ketqua.xn_id', '=', 'loaixn.xetnghiem_id') // Kết nối bảng ketqua với loaixn thông qua xetnghiem_id
        ->join('enrolls', 'ketqua.hoso_id', '=', 'enrolls.id') // Kết nối bảng ketqua với enrolls thông qua hoso_id
        ->join('info_patients', 'enrolls.patient_id', '=', 'info_patients.id') 
        ->join('patients', 'patients.user_id', '=', 'info_patients.id') // Kết nối bảng enrolls với info_patients thông qua patient_id
        ->where('ketqua.hoso_id', $id) // Giới hạn chỉ lấy hồ sơ có id tương ứng
        ->select(
            'ketqua.xn_id as makq',          // Mã kết quả xét nghiệm
            'ketqua.ketqua as kq',           // Kết quả xét nghiệm
            'loaixn.xetnghiem_id as xn_id',   // Mã xét nghiệm
            'loaixn.tenxn as tenxn',          // Tên loại xét nghiệm
            'enrolls.id as mahs',             // Mã hồ sơ
            'info_patients.HoTen as ht',      // Tên bệnh nhân
            'patients.user_id as mabn',       // Mã bệnh nhân
            'enrolls.date'                    // Ngày khám
        )
        ->get();
    $all_kq = DB::table('loaixn')->get();
        return view('admin.ketqua.edit_kq', [
            'user' => $adminUser,
            'kq' => $kq, // Truyền dữ liệu kết quả xét nghiệm
            'id' => $id
        ]);    
    }
    public function update_kq(Request $request, $id)
    {
        $validatedData = $request->validate([
            'xn_id' => 'required|array',
            'xn_id.*' => 'integer',
            'ketqua' => 'required|array',
            'ketqua.*' => 'string|max:255',
        ]);

        DB::beginTransaction();

        try {
            foreach ($validatedData['xn_id'] as $index => $xn_id) {
                // Lấy ra bản ghi hiện tại của mã xét nghiệm và kết quả
                $currentData = DB::table('ketqua')
                                ->where('hoso_id', $id)
                                ->where('xn_id', $xn_id)
                                ->first();

                if ($currentData) {
                    // Nếu chỉ thay đổi kết quả
                    if ($currentData->ketqua !== $validatedData['ketqua'][$index]) {
                        DB::table('ketqua')
                        ->where('xn_id', $currentData->xn_id) // Sử dụng thuộc tính id từ cơ sở dữ liệu
                        ->update(['ketqua' => $validatedData['ketqua'][$index]]);
                    }
                } else {
                    // Nếu mã xét nghiệm mới, thì chèn vào
                    DB::table('ketqua')->insert([
                        'hoso_id' => $id,
                        'xn_id' => $xn_id,
                        'ketqua' => $validatedData['ketqua'][$index],
                    ]);
                }
            }
            DB::commit();
            Session()->put('message', 'Cập nhật thông tin kết quả thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }

        return Redirect::to('admin/all-kq');
    }
    public function delete_kq($id) {
        $kq = DB::table('ketqua')->where('xn_id', $id)->first();
        if (!$kq) {
            return back()->withErrors(['message' => 'Không tìm thấy kết quả']);
        }
        
        // Xóa dữ liệu liên quan từ bảng 'ketqua'
        DB::table('ketqua')->where('xn_id', $id)->delete();
        
        // Xóa dữ liệu liên quan từ bảng 'patients' và 'info_patients'
        
        
        Session()->put('message', 'Xóa kết quả thành công');
        return Redirect::to('admin/all-kq');
    }
    public function exportPdf($enrollId)
    {
        $enroll = Enroll::with(['ketqua.loaixn'])->findOrFail($enrollId); // Truy vấn thông tin hồ sơ khám và kết quả xét nghiệm kèm tên loại xét nghiệm
        $patient = $enroll->patient; // Thông tin bệnh nhân liên kết
        $results = $enroll->ketqua; // Các kết quả xét nghiệm liên quan
    
        // Tạo nội dung PDF từ view
        $pdf = Pdf::loadView('pdf.result', compact('enroll', 'patient', 'results'));
          // Lưu file PDF vào thư mục public/pdf
        $fileName = 'result_' . $enroll->id . '.pdf';
        $pdf->save(public_path('pdf/' . $fileName)); // Lưu trực tiếp vào thư mục public/pdf

        // Lưu đường dẫn file PDF vào DB
        $enroll->result_pdf = 'pdf/' . $fileName;
        $enroll->save();

        return redirect()->route('pdf.result', ['id' => $enroll->id])->with('success', 'Xuất file PDF thành công!');
        // Lưu file PDF vào thư mục storage
        // $fileName = 'result_' . $enroll->id . '.pdf';
        // Storage::put('public/results/' . $fileName, $pdf->output());
        // // // Trả về URL công khai cho người dùng
        // // $pdfUrl = asset('storage/results/' . $fileName);
        // // Lưu đường dẫn file PDF vào DB
        // $enroll->result_pdf = 'pdf/' . $fileName;
        // $enroll->save();
    
        // return redirect()->route('pdf.result', ['id' => $enroll->id])
        // ->with('success', 'Xuất file PDF thành công!')
        // ->with('pdfUrl', $pdfUrl); // Truyền URL để người dùng có thể xem
    }
    public function showResult($id)
    {
        $enroll = Enroll::with(['ketqua.loaixn'])->findOrFail($id); // Truy vấn thông tin hồ sơ khám và kết quả xét nghiệm kèm tên loại xét nghiệm
        $patient = $enroll->patient; // Lấy thông tin bệnh nhân liên kết
        $results = $enroll->ketqua; // Các kết quả xét nghiệm liên quan
            // Tạo file PDF từ view
            $pdf = Pdf::loadView('pdf.result', compact('enroll', 'patient', 'results'));
                
            // Trả về PDF dạng stream
            return $pdf->stream('result_' . $enroll->id . '.pdf');    
    }
    public function kq_details($id) {
        // Lấy thông tin admin hiện tại
        $adminUser = Auth::guard('admins')->user();
        
    // Lấy dữ liệu từ bảng ketqua và enrolls
    $ketquaDetails = DB::table('ketqua')
    ->join('loaixn', 'ketqua.xn_id', '=', 'loaixn.xetnghiem_id') // Kết nối bảng ketqua với loaixn thông qua xetnghiem_id
    ->join('enrolls', 'ketqua.hoso_id', '=', 'enrolls.id') // Kết nối bảng ketqua với enrolls thông qua hoso_id
    ->join('info_patients', 'enrolls.patient_id', '=', 'info_patients.id') 
    ->join('patients','patients.user_id','=','info_patients.id')// Kết nối bảng enrolls với info_patients thông qua patient_id
    ->where('ketqua.hoso_id', $id) // Giới hạn chỉ lấy hồ sơ có id tương ứng
    
    ->select(
        'ketqua.xn_id as makq',          // Mã kết quả xét nghiệm
        'ketqua.ketqua as kq',           // Kết quả xét nghiệm
        'loaixn.tenxn as tenxn',          // Tên loại xét nghiệm
        'enrolls.id as mahs',             // Mã hồ sơ
        'info_patients.HoTen as ht',      // Tên bệnh nhân
        'patients.user_id as mabn',  // Mã bệnh nhân
        'enrolls.date'               // Ngày khám
    )
    ->get(); // Lấy tất cả dữ liệu

        return view('admin.ketqua.view_kq', [
            'ketquaDetails' => $ketquaDetails,  // Dữ liệu kết quả xét nghiệm
            'adminUser' => $adminUser           // Thông tin người dùng admin đang đăng nhập
        ]);

    }
    
}
