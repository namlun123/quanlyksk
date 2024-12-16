@extends("layouts.admin")
@section("content")
<!-- Bootstrap DatePicker JavaScript -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<div class="container py-2">
    @php
        $all_inforadmin = DB::table('info_admins')->where('id', $user->admin_id)->get();
    @endphp
    <form action="{{ route('admin.info.admin') }}" method="post" enctype="multipart/form-data">
        @csrf
        @foreach($all_inforadmin as $inforadmin)
        <div class="col-lg-6">
            <h4 class="text-uppercase text-title-form">THÔNG TIN CÁ NHÂN</h4>
            <div class="form-group col-lg-6">
                <label class="form-label mb-1 text-2 required">Họ và tên</label>
                <input type="text" class="form-control text-3 h-auto py-2" placeholder="Nhập tên người dùng" required="" name="username" value="{{ $inforadmin-> HoTen }}">
            </div>
            <div class="form-group col-lg-6">
                <label class="form-label mb-1 text-2 required">Ngày Sinh</label>
                <input type="date" class="form-control text-3 h-auto py-2" placeholder="Nhập mật khẩu" name="ngaysinh" value="{{ $inforadmin->NgaySinh }}">
            </div>
            <div class="form-group col-lg-12">
                <label class="form-label mb-1 text-2 required">Số điện thoại</label>
                <input type="text" class="form-control text-3 h-auto py-2" name="SDT" data-msg-required="Vui lòng nhập Số điện thoại" placeholder="Nhập SĐT" maxlength="10" required="" value="{{ $inforadmin->SDT }}">
            </div>
        </div>
        <div class="form-group col-lg-12">
            <button type="submit" name="update_tkadmin" class="btn btn-info">Cập nhật thông tin</button>
            <!-- Nút đổi mật khẩu -->
            <a href="{{ route('admin.change-password') }}" class="btn btn-warning ml-2">Đổi mật khẩu</a>
        </div>
        @endforeach
    </form>
</div>
@endsection
