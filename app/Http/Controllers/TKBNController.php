<?php


namespace App\Http\Controllers;

use App\Models\Benhnhan;
use App\Models\TKbenhnhan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TKBNController extends Controller
{
    public function all_tkbn() {
        $adminUser = Auth::guard('admins')->user();
        $all_tkbn = DB::table('patients')->orderBy('id', 'desc')->get();
        return view('admin.benhnhan.all_tkbn', ['user'=>$adminUser], ['all_tkbn'=>$all_tkbn]);
    }
    public function add_tkbn() {
        $adminUser = Auth::guard('admins')->user();
        return view('admin.benhnhan.add_tkbn', ['user'=>$adminUser]);
    }
}
