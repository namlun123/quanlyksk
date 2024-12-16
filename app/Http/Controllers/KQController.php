<?php

namespace App\Http\Controllers;

use App\Models\Benhnhan;
use App\Models\TKbenhnhan;
use App\Models\KQ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class KQController extends Controller
{
    public function get_thong_tin_bn($id) {
        // Lấy thông tin của bn
        $bn = Benhnhan::find($id);

        // Lấy thông tin của Kh
        $khs = DB::table('patients')->where('user_id', $id)->first();

        $data = [
            'bn' => $bn,
            'kh' => $khs,
        ];

        // Trả về dữ liệu dưới dạng JSON
        return response()->json($data);
    }
    public function add_kq() {
        $adminUser = Auth::guard('admins')->user();
        return view('admin.ketqua.add_kq', ['user'=>$adminUser]);
    }
}
