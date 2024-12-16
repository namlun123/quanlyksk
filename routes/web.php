<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\SepayController;
use App\Http\Middleware\BN;
use App\Http\Middleware\TKBN;
use Illuminate\Foundation\Application;
use App\Http\Middleware\Admin;
use App\Http\Controllers\CaptchaController;

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

