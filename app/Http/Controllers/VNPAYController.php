<?php

namespace App\Http\Controllers;


use DateTime;
use DateInterval; // Import lớp DateInterval nếu sử dụng
use Illuminate\Http\Request;
use App\Http\Middleware\TKBN;
use App\Http\Middleware\User;
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

class VNPAYController extends Controller
{

    public function createPayment($enroll_id, Request $request)
    {
        $enroll = Enroll::find($enroll_id);
        
        $vnp_TmnCode = "PHLIXEQM";
        $vnp_HashSecret = "FZG0G0EH4F3KJM5H8C2PGYNGYPY2R54R";
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost/quanlyksk/vnpay/return"; // Change the return URL to a new route

        // Tính thời gian hết hạn (15 phút sau thời điểm hiện tại)
        $expire = Carbon::now('Asia/Ho_Chi_Minh')->addMinutes(15)->format('YmdHis');

        $vnp_TxnRef = $enroll_id; //Mã giao dịch thanh toán tham chiếu của merchant
        $vnp_Amount = $enroll->total_cost; // Số tiền thanh toán
        $vnp_Locale = 'vn'; //Ngôn ngữ chuyển hướng thanh toán
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount* 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => "Thanh toan GD:",
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate"=>$expire
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        session()->put('id', $enroll_id);
        session()->save();
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        header('Location: ' . $vnp_Url);
        die();
    }
    public function handleReturn(Request $request)
    {
        $vnp_TmnCode = "PHLIXEQM"; //Mã định danh merchant kết nối (Terminal Id)
        $vnp_HashSecret = "FZG0G0EH4F3KJM5H8C2PGYNGYPY2R54R"; //Secret key
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
    
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash === $vnp_SecureHash) {
            // Xác thực phản hồi thanh toán
            $responseCode = $request->get('vnp_ResponseCode');
            $redirectUrl = 'http://localhost/quanlyksk/dangkykham';
            
            if ($responseCode === '00') {
                // Thanh toán thành công
                $enrollmentId = session()->get('id'); // Lấy ID đăng ký từ session
                
                if ($enrollmentId) {
                    DB::table('enrolls')
                        ->where('id', $enrollmentId)
                        ->update(['status' => 1]); // Cập nhật trạng thái thành "đã thanh toán"
                    
                    session()->forget('id'); // Xóa ID đăng ký trong session
                    return redirect($redirectUrl)
                        ->with('alert', 'Thanh toán thành công');
                } else {
                    return redirect($redirectUrl)
                        ->with('error', 'Không tìm thấy ID đăng ký. Vui lòng thử lại.');
                }
            } else {
                // Thanh toán thất bại
                return redirect($redirectUrl)
                    ->with('alert', 'Thanh toán không thành công. Mã phản hồi: ' . $responseCode);
            }
        } else {
            // Chữ ký không hợp lệ
            return redirect('http://localhost/quanlyksk/dangkykham')
                ->with('error', 'Chữ ký thanh toán không hợp lệ.');
        }
        
    }
    
}
