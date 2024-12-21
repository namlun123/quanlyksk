<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\SepayController;
use App\Http\Controllers\VNPAYController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManageAdminController;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\TKBNController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\KQController;
use App\Http\Controllers\EnrollController;
use App\Http\Middleware\BN;
use App\Http\Middleware\TKBN;
use Illuminate\Foundation\Application;
use App\Http\Middleware\Admin;
use App\Http\Controllers\ChuyenKhoaController;
use App\Http\Controllers\LoaiXNController;
use App\Http\Controllers\CakhamController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\DoctorController;


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
// lịch sử khám
Route::get('/enroll-history', [UserController::class, 'enroll_history'])->name('enroll.history');
Route::get('user/enroll/{id}/edit', [UserController::class, 'edit_enroll'])->name('user.edit.enroll');
Route::post('user/enroll/{id}/update', [UserController::class, 'update_enroll'])->name('user.update.enroll');
Route::get('user/enroll/{id}/delete', [UserController::class, 'delete_enroll'])->name('user.delete.enroll');
Route::get('/user/showPdf/{id}', [UserController::class, 'showPdf'])->name('user.showPdf');

//đổi mật khẩu
Route::get('/change-password', [UserController::class, 'showChangePasswordForm'])->name('show.change.password');
Route::post('/change-password', [UserController::class, 'changePassword'])->name('user.change.password');
//xóa tài khoản
// Route::get('user/delete-account', [UserController::class, 'delete_account'])->name('user.delete.account');
Route::get('/dangkykham', [AppointmentController::class, 'create_appointment'])->name('appointment.create');
Route::post('/appointment/store/{id}', [AppointmentController::class, 'store_appointment'])->name('appointment.store');
Route::get('/get-doctors/{locationId}/{specializationId}', [AppointmentController::class, 'getDoctors']);
Route::get('/get-timeslots/{locationId}/{doctorId}/{date}', [AppointmentController::class, 'getTimeSlots']);
Route::get('/get-timeslots/{locationId}/{doctorId}/{selectedDate}', [AppointmentController::class, 'getTimeSlots']);
Route::get('/appointment/{id}/edit', [AppointmentController::class, 'edit_appointment'])->name('appointment.edit');
Route::put('/appointment/{appointment_id}/update', [AppointmentController::class, 'update_appointment'])->name('appointment.update');
//Route::post('/appointment/update/{appointment_id}', [AppointmentController::class, 'update_appointment'])->name('appointment.update');

Route::get('/chatbot', [ChatbotController::class, 'showChatbot']);
Route::post('/chatbot/request', [ChatbotController::class, 'handleRequest'])->name('chatbot.request');

// Route cho trang thanh toán
Route::get('/vnpay/payment/{enroll_id}', [VNPAYController::class, 'createPayment'])->name('appointment.payment');

// Route cho trang trả kết quả từ VNPAY
Route::get('/vnpay/return', [VNPAYController::class, 'handleReturn'])->name('appointment.return');



//View thông tin hướng dẫn khám
Route::get('/huongdankham', [UserController::class, 'huongdankham'])->name('huongdankham');      

//view Chuyên khoa
Route::get('/chuyenkhoa', [UserController::class, 'chuyenkhoa'])->name('chuyenkhoa');   

//View Bác sĩ
Route::get('/Doctor', [UserController::class, 'Doctor'])->name('Doctor');   




// View Admin
Route::get('/admin/login', [AdminController::class, 'admin_login'])->name('admin_login');
Route::post('/admin/login', [AdminController::class, 'loginPost'])->name('admin.loginPost');
Route::get('/admin/logout', [AdminController::class, 'admin_logout'])->name('admin.logout');

//trang thống kê
Route::middleware([Admin::class])->group(function () {
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

//Nút Profile Admin
Route::match(['get', 'post'], '/admin/info-admin', [ManageAdminController::class, 'info_admin'])->name('admin.info.admin');

//Quản lý tài khoản admin
    Route::get('/admin/all-admins', [ManageAdminController::class, 'all_admins'])->name('admin.admins');
    Route::get('/admin/add-tkadmin', [ManageAdminController::class, 'add_tkadmin'])->name('admin.add.tkadmin');
    Route::get('/admin/all-tkadmin', [ManageAdminController::class, 'all_tkadmin'])->name('admin.tkadmin');
    Route::get('admin/tkadmin/{id}/edit', [ManageAdminController::class, 'edit_tkadmin'])->name('admin.edit.tkadmin');
    Route::get('admin/admins/{id}/edit', [ManageAdminController::class, 'edit_admins'])->name('admin.edit.admins');
    Route::get('admin/tkadmin/{id}/delete', [ManageAdminController::class, 'delete_tkadmin'])->name('admin.delete.tkadmin');
    Route::get('admin/admins/{id}/delete', [ManageAdminController::class, 'delete_admins'])->name('admin.delete.admins');
    Route::post('/admin/save-tkadmin', [ManageAdminController::class, 'save_tkadmin'])->name('admin.save.tkadmin');
    Route::post('admin/tkadmin/{id}/update', [ManageAdminController::class, 'update_tkadmin'])->name('admin.update.tkadmin');
    Route::post('admin/admins/{id}/update', [ManageAdminController::class, 'update_admins'])->name('admin.update.admins');
    Route::post('admin/tkadmin/{id}/password', [ManageAdminController::class, 'password_tkadmin'])->name('admin.password.tkadmin');
    Route::post('/admin/tkadmin/login', [ManageAdminController::class, 'loginPost_tkadmin'])->name('admin.loginPost.tkadmin');
    Route::post('/admin/tkadmin/{id}/changepassword', [ManageAdminController::class, 'changePassword'])->name('admin.changepassword.tkadmin');
    Route::get('admin/tkadmin/{id}/password', [ManageAdminController::class, 'password_tkadmin'])->name('admin.password.tkadmin');
    //đổi mật khẩu tk admin cá nhân
    Route::get('/admin/change-password', [AdminController::class, 'showChangePasswordForm'])->name('admin.change-password');
    Route::post('/admin/change-password', [AdminController::class, 'changePassword'])->name('admin.change-password.post');
    Route::post('/admin/update-admin', [AdminController::class, 'updateAdmin'])->name('admin.update.adminsprofile');



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
    
//Quản lý ca khám
    Route::post('/admin/save-cakham', [CakhamController::class, 'save_cakham'])->name('admin.save.cakham');
    Route::get('/admin/all-cakham', [CakhamController::class, 'all_cakham'])->name('admin.cakham');
    // Route GET để hiển thị form
Route::get('/admin/add-cakham', [CakhamController::class, 'add_cakham'])->name('admin.add.cakham');

// Route POST để xử lý form khi người dùng chọn chi nhánh
    Route::post('/admin/add-cakham', [CakhamController::class, 'add_cakham'])->name('admin.add.cakham.submit');

    Route::get('admin/cakham/{id}/edit', [CakhamController::class, 'edit_cakham'])->name('admin.edit.cakham');
    Route::post('admin/cakham/{id}/update', [CakhamController::class, 'update_cakham'])->name('admin.update.cakham');
    Route::get('admin/cakham/{id}/delete', [CakhamController::class, 'delete_cakham'])->name('admin.delete.cakham');
    Route::get('/admin/get-doctors', [CakhamController::class, 'get_doctors_by_location'])->name('admin.get.doctors');
    Route::put('admin/cakham/{id}/update', [CakhamController::class, 'update_cakham']);



    
});


//quản lý kết quả
Route::get('/admin/add-kq', [KQController::class, 'add_kq'])->name('admin.add.kq');
Route::post('/admin/add-kq/store', [KQController::class, 'store'])->name('admin.add.kq.store');
Route::get('/admin/all-kq', [KQController::class, 'all_kq'])->name('admin.kq');
Route::post('/admin/save-kq', [KQController::class, 'save_kq'])->name('admin.save.kq');
Route::get('admin/kq/{id}/details', [KQController::class, 'kq_details'])->name('admin.view.kq');

Route::get('admin/kq/{id}/edit', [KQController::class, 'edit_kq'])->name('admin.edit.kq');
Route::put('admin/kq/{id}/update', [KQController::class, 'update_kq'])->name('admin.update.kq');
Route::get('admin/kq/{id}/delete', [KQController::class, 'delete_kq'])->name('admin.delete.kq');
Route::get('/admin/export-pdf/{enrollId}', [KQController::class, 'exportPdf'])->name('admin.export.pdf');
// trong tệp routes/web.php
Route::get('admin/result/{id}', [KQController::class, 'showResult'])->name('pdf.result');

// Route::get('admin/tkbn/{id}/delete', [TKBNController::class, 'delete_tkbn'])->name('admin.delete.tkbn');

Route::get('/get-thong-tin-bn/{id}', [KQController::class, 'get_thong_tin_bn'])->name('get.tt.bn');
Route::get('/get-ten-xetnghiem/{id}', [KQController::class, 'getTenXetNghiem']);



//Quản lý chuyên khoa
Route::get('/admin/all-chuyenkhoa', [ChuyenKhoaController::class, 'all_chuyenkhoa'])->name('admin.all.chuyenkhoa');
Route::get('/admin/add-chuyenkhoa', [ChuyenKhoaController::class, 'add_chuyenkhoa'])->name('admin.add.chuyenkhoa');
Route::post('/admin/save-chuyenkhoa', [ChuyenKhoaController::class, 'save_chuyenkhoa'])->name('admin.save.chuyenkhoa');
Route::get('/admin/edit-chuyenkhoa/{id}', [ChuyenKhoaController::class, 'edit_chuyenkhoa'])->name('admin.edit.chuyenkhoa');
Route::get('/admin/delete-chuyenkhoa/{id}', [ChuyenKhoaController::class, 'delete_chuyenkhoa'])->name('admin.delete.chuyenkhoa');
Route::post('/admin/update-chuyenkhoa/{id}', [ChuyenKhoaController::class, 'update_chuyenkhoa'])->name('admin.update.chuyenkhoa');

//Quản lý loại xét nghiệm
Route::get('/admin/all-loaixn', [LoaiXNController::class, 'all_loaixn'])->name('admin.all.loaixn');
Route::get('/admin/add-loaixn', [LoaiXNController::class, 'add_loaixn'])->name('admin.add.loaixn');
Route::post('/admin/save-loaixn', [LoaiXNController::class, 'save_loaixn'])->name('admin.save.loaixn');
Route::get('/admin/edit-loaixn/{id}', [LoaiXNController::class, 'edit_loaixn'])->name('admin.edit.loaixn');
Route::get('/admin/delete-loaixn/{id}', [LoaiXNController::class, 'delete_loaixn'])->name('admin.delete.loaixn');
Route::post('/admin/update-loaixn/{id}', [LoaiXNController::class, 'update_loaixn'])->name('admin.update.loaixn');

//Quản lý địa điểm khám
Route::get('/admin/all-location', [LocationController::class, 'all_location'])->name('admin.all.locations');
Route::get('/admin/add-location', [LocationController::class, 'add_location'])->name('admin.add.locations');
Route::post('/admin/save-location', [LocationController::class, 'save_location'])->name('admin.save.location');
Route::get('/admin/edit-location/{id}', [LocationController::class, 'edit_location'])->name('admin.edit.location');
Route::get('/admin/delete-location/{id}', [LocationController::class, 'delete_location'])->name('admin.delete.location');
Route::post('/admin/update-location/{id}', [LocationController::class, 'update_location'])->name('admin.update.location');
  
//Quản lý bác sĩ
Route::get('/admin/all-Doctor', [DoctorController::class, 'all_Doctor'])->name('admin.all.Doctor');
Route::get('/admin/add-Doctor', [DoctorController::class, 'add_Doctor'])->name('admin.add.Doctor');
Route::post('/admin/save-Doctor', [DoctorController::class, 'save_Doctor'])->name('admin.save.Doctor');
Route::get('/admin/edit-Doctor/{id}', [DoctorController::class, 'edit_Doctor'])->name('admin.edit.doctor');
Route::get('/admin/delete-Doctor/{id}', [DoctorController::class, 'delete_Doctor'])->name('admin.delete.doctor');
Route::post('/admin/update-Doctor/{id}', [DoctorController::class, 'update_Doctor'])->name('admin.update.doctor');

  
