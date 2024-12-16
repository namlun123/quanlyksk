<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\InfoAdmin; // Import model
class ManageAdminController extends Controller
{
    public function info_admin()
    {
        echo'123';
        // $adminUser = Auth::guard('admins')->user();
        // return view('admin.tkadmin.info_admin', ['user'=>$adminUser]);
    }
}
