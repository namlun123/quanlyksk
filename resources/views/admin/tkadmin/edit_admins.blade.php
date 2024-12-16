@extends("layouts.admin")
@section("content")
<!-- Bootstrap DatePicker JavaScript -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type="text/javascript"></script>

<div class="container py-2">
        <div class=" mb-4">
            <div class="">
                <div class="row place-userInfor">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form  action="{{ route('admin.update.admins', ['id' => $admins->id]) }}"  method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="col-lg-6">
                            <h4 class="text-uppercase text-title-form">CẬP NHẬT THÔNG TIN ADMIN</h4>
                            <div class="form-group col-lg-12">
                                <label class="form-label mb-1 text-2 required">Tên người dùng</label>
                                <input type="text" value="{{$admins ->HoTen}}" class="form-control text-3 h-auto py-2" placeholder="Nhập tên người dùng" required="" name="hoten">
                            </div>
                            <div class="form-group col-lg-12">
                                <label class="form-label mb-1 text-2 required">Ngày sinh</label>
                                <input type="date" value="{{$admins ->NgaySinh}}"  class="form-control text-3 h-auto py-2 type-date" name="ngaysinh" id="Day1" placeholder="DD/MM/YYYY" required="">
                            </div>
                            <div class="form-group">
                            <div class="col-md-12">
                                <label class="form-label mb-1 text-2 required">Số điện thoại</label>
                                <input type="text" name="sdt" value="{{$admins ->SDT}}" class="form-control text-3 h-auto py-2" placeholder="Nhập số điện thoại" min_length="1" max_length="10">
                            </div>
                        </div>
                        
                        </div>

                        <div class="form-group col-lg-12">
                        <button type="submit" name="update_admins" class="btn btn-info">Cập nhật tài khoản</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

</div>

@endsection
