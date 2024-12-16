<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\SepayController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManageAdminController;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\TKBNController;
use App\Http\Middleware\BN;
use App\Http\Middleware\TKBN;
use Illuminate\Foundation\Application;
use App\Http\Middleware\Admin;

Route::get('/', [CaptchaController::class, 'index']);
Route::get('/reload-captcha', [CaptchaController::class, 'reloadCaptcha']);
//USER
//đăng kí, đăng nhập đăng xuất
Route::get('/', [UserController::class, 'index'])->name('index');
Route::get('/home', [UserController::class, 'index'])->name('pages.home');
Route::get('/trang-chu', [UserController::class, 'index'])->name('trang-chu');
Route::get('/log-in', [UserController::class, 'userlogin'])->name('userlogin');
Route::get('/register', [UserController::class, 'userregister'])->name('userregister');
Route::post('/register-kh', [UserController::class, 'register_kh'])->name('register-kh');
Route::post('/login-kh', [UserController::class, 'login_kh'])->name('login-kh');
Route::get('/dang-xuat', [UserController::class, 'sign_out'])->name('dang-xuat');
//sửa thông tin
Route::get('/user-profile', [UserController::class, 'user_profile'])->name('user-profile');
Route::post('user/profile/{id}/update', [UserController::class, 'update_profile'])->name('user.update.profile');
//đổi mật khẩu
Route::get('/change-password', [UserController::class, 'showChangePasswordForm'])->name('show.change.password');
Route::post('/change-password', [UserController::class, 'changePassword'])->name('user.change.password');
//xóa tài khoản
// Route::get('user/delete-account', [UserController::class, 'delete_account'])->name('user.delete.account');
Route::get('/dangkykham', [AppointmentController::class, 'create_appointment'])->name('appointment.create');
Route::post('/appointment/store/{id}', [AppointmentController::class, 'store_appointment'])->name('appointment.store');
Route::get('/get-doctors/{locationId}/{specializationId}', [AppointmentController::class, 'getDoctors']);
Route::get('quanlyksk/get-timeslots/{locationId}/{doctorId}/{date}', [AppointmentController::class, 'getTimeSlots']);
Route::get('quanlyksk/get-timeslots/{locationId}/{doctorId}/{selectedDate}', [AppointmentController::class, 'getTimeSlots']);
Route::get('quanlyksk/payment/{enroll_id}', [SepayController::class, 'showPaymentPage'])->name('payment.page'); // Trang thanh toán
Route::post('/payment', [SepayController::class, 'createPayment'])->name('payment.create'); // Tạo giao dịch
Route::get('/payment-success', [SepayController::class, 'paymentSuccess'])->name('payment.success'); // Thành công
Route::post('/payment-webhook', [SepayController::class, 'handleWebhook'])->name('payment.webhook'); // Webhook




Route::middleware([BN::class])->group(function () {
    Route::get('/lichthi', [UserController::class, 'lichthi'])->name('lich-thi');
    Route::get('/diadiemthi', [UserController::class, 'diadiemthi'])->name('dia-diem-thi');
    Route::get('/dangkythi/{baithi_id}', [UserController::class, 'dangkythi'])->name('dang-ky-thi');
    Route::get('/user-profile', [UserController::class, 'user_profile'])->name('user-profile');
    Route::post('user/profile/{id}/update', [UserController::class, 'update_profile'])->name('user.update.profile');
    Route::get('/enroll-history', [UserController::class, 'enroll_history'])->name('enroll.history');
});


// View Admin
Route::get('/admin/login', [AdminController::class, 'admin_login'])->name('admin_login');
Route::post('/admin/login', [AdminController::class, 'loginPost'])->name('admin.loginPost');
Route::get('/admin/logout', [AdminController::class, 'admin_logout'])->name('admin.logout');
//trang thống kê
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

//Nút Profile Admin
Route::get('/admin/info-admin', [ManageAdminController::class, 'info_admin'])->name('admin.info.admin');

//quản lý bệnh nhân
Route::get('/admin/all-bn', [TKBNController::class, 'all_bn'])->name('admin.bn');
    Route::get('/admin/add-bn', [TKBNController::class, 'add_bn'])->name('admin.add.bn');
    Route::post('/admin/save-bn', [TKBNController::class, 'save_bn'])->name('admin.save.bn');
    Route::get('admin/bn/{id}/edit', [TKBNController::class, 'edit_bn'])->name('admin.edit.bn');
    Route::post('admin/bn/{id}/update', [TKBNController::class, 'update_bn'])->name('admin.update.bn');
    Route::get('admin/bn/{id}/delete', [TKBNController::class, 'delete_bn'])->name('admin.delete.bn');
    Route::get('/admin/all-tkbn', [TKBNController::class, 'all_tkbn'])->name('admin.tkbn');
    Route::get('/admin/add-tkbn', [TKBNController::class, 'add_tkbn'])->name('admin.add.tkbn');
    Route::post('/admin/save-tkbn', [TKBNController::class, 'save_tkbn'])->name('admin.save.tkbn');
    Route::get('admin/tkbn/{id}/edit', [TKBNController::class, 'edit_tkbn'])->name('admin.edit.tkbn');
    Route::post('admin/tkbn/{id}/update', [TKBNController::class, 'update_tkbn'])->name('admin.update.tkbn');
    Route::get('admin/tkbn/{id}/delete', [TKBNController::class, 'delete_tkbn'])->name('admin.delete.tkbn');