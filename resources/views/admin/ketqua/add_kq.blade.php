@extends("layouts.admin")
@section("content")
<!-- Bootstrap DatePicker JavaScript -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type="text/javascript"></script>
<style>

label.required:after {
    content: "*";
    font-size: 0.8em;
    margin: 0.3em;
    position: relative;
    top: -2px;
    color: red;
}
</style>
  <div style="min-height:48vh">

    <style>
        #Image3x4{
            z-index:-1;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('public/frontend/css/normal-exam.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/coppie/croppie.min.css') }}">
    <style>
        label.cabinet{
        display: block;
        cursor: pointer;
    }

    label.cabinet input.file{
        position: relative;
        height: 100%;
        width: auto;
        opacity: 0;
        -moz-opacity: 0;
      filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
      margin-top:-30px;
    }

    #upload-demo{
        width: 100%;
            height: 550px;
      padding-bottom:25px;
    }
     .text-color-orange{
         color:#F25A18;
     }
    </style>
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
                    <form  action="{{ route('admin.save.kq') }}"  method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                        <h4 style ="margin-bottom: 30px; font-size: 26px "; class="text-uppercase text-center text-title-form">THÔNG TIN KẾT QUẢ KHÁM</h4>

                        <div class="col-lg-5">
                            <div class="row col-lg-12 d-flex justify-content-center align-items-center">
                                <div class="form-group col-lg-12">
                                    <label class="form-label mb-1 text-2 required">Chọn bệnh nhân</label>
                                    @php
                                        $all_infor = DB::table('info_patients')
                                        ->join('patients', 'info_patients.id', '=', 'patients.user_id')
                                        ->select('info_patients.id as bn_id','info_patients.*','patients.*')
                                        ->get();
                                    @endphp

                                    <select class="form-select form-control h-auto py-2" id="bn" name="bn" required="" data-msg-required="Vui lòng chọn bệnh nhân">
                                        <option value="0" selected>Chọn bệnh nhân</option>
                                        @foreach($all_infor as $infor)
                                        <option value="{{$infor->bn_id}}">{{$infor->bn_id}} - {{$infor->HoTen}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-lg-12">
                                        <label class="form-label mb-1 text-2 required">Họ và tên bệnh nhân</label>
                                        <input readonly type="text" value="" class="form-control text-3 h-auto py-2" name="hoten" placeholder="Nhập họ và tên bệnh nhân" aria-invalid="true" maxlength="255" required="" data-msg-required="Vui lòng nhập họ và tên bệnh nhân" data-rule-pattern="^[a-zA-Z_ÀÁÂÃÈÉÊẾÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêếìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹý\ ]+$" data-msg-pattern="Tên không đúng định dạng">
                                    </div>

                                    <!-- <div class="form-group col-lg-12">
                                        <div style = "padding-left: 0px";class ="col-lg-6 ">
                                            <label class="form-label mb-1 text-2 required">Ngày sinh</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control text-3 h-auto py-2 type-date" name="ngaysinh" id="BirthDay"  placeholder="YYYY/MM/DD" required="">
                                                    <label class="input-group-text" for="BirthDay"><i class="fas fa-calendar-alt"></i></label>
                                                </div>
                                        </div>
                                        <div style = "padding-left: 0px";class ="col-lg-6">
                                        <label class="form-label mb-1 text-2 required">Giới tính</label>
                                            <div class="d-inline">
                                                <div class="col-lg-6 form-check form-check-inline">
                                                    <input disabled class="form-check-input" type="radio" name="gioitinh" id="1" value="1" required>
                                                    <label class="form-check-label" for="1">Nam</label>
                                                </div>
                                                <div class="col-lg-6 form-check form-check-inline">
                                                    <input disabled class="form-check-input" type="radio" name="gioitinh" id="0" value="0">
                                                    <label class="form-check-label" for="0">Nữ</label>
                                                </div>
                                           </div>
                                        </div> -->

                                        <div class="form-group col-lg-12 row">
                                            <div class="form-group col-lg-6">
                                            <label class="form-label mb-1 text-2 required">Ngày sinh</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control text-3 h-auto py-2 type-date" name="ngaysinh" id="BirthDay"  placeholder="YYYY/MM/DD" required="">
                                                                <label class="input-group-text" for="BirthDay"><i class="fas fa-calendar-alt"></i></label>
                                                            </div>
                                            </div>
                                            <div class="form-group col-lg-6">
                                            <label class="form-label mb-1 text-2 required">Giới tính</label>
                                                        <div class="d-inline">
                                                            <div class="col-lg-6 form-check form-check-inline">
                                                                <input disabled class="form-check-input" type="radio" name="gioitinh" id="1" value="1" required>
                                                                <label class="form-check-label" for="1">Nam</label>
                                                            </div>
                                                            <div class="col-lg-6 form-check form-check-inline">
                                                                <input disabled class="form-check-input" type="radio" name="gioitinh" id="0" value="0">
                                                                <label class="form-check-label" for="0">Nữ</label>
                                                            </div>
                                                    </div>
                                            </div>    
                                    <div class="form-group col-lg-5">
                        
                                    </div>
                                
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-7 ">
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label class="form-label mb-1 text-2 required">Số nhà, đường/phố</label>
                                    <input readonly type="text" value="" class="form-control text-3 h-auto py-2" placeholder="Nhập số nhà, đường/phố/phường/quận/thành phố" name="diachi" required="" maxlength="255" data-msg-required="Vui lòng nhập thông tin số nhà, đường phố">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="form-group col-lg-4">
                                    <label class="form-label mb-1 text-2 required" for="city">Tỉnh/Thành phố</label>
                                    <select class="form-select form-control h-auto py-2" id="city" name="province" required="" data-msg-required="Vui lòng chọn Tỉnh/Thành phố">
                                        <option name="province" value="" selected></option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label class="form-label mb-1 text-2 required" for="district">Quận/Huyện</label>
                                    <select class="form-select form-control h-auto py-2" id="district" name="district" required="" data-msg-required="Vui lòng chọn Quận/Huyện">
                                        <option name="district" value="" selected></option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label class="form-label mb-1 text-2 required" for="ward">Phường/Xã</label>
                                    <select class="form-select form-control h-auto py-2" id="ward" name="ward" required="" data-msg-required="Vui lòng chọn Xã/Phường">
                                        <option name="ward" value="" selected></option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="form-label mb-1 text-2 required">Số điện thoại</label>
                                    <input readonly class="form-control text-3 h-auto py-2" type="text" name="sdt" placeholder="Nhập số điện thoại" required="" data-msg-required="Vui lòng nhập số điện thoại" data-rule-minlength="10" maxlength="10" data-msg-minlength="Số điện thoại phải đủ 10 số" data-rule-number="^[0-9]{10}" data-msg-number="validate.Phone.pattern">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="form-label mb-1 text-2 required">Email</label>
                                    <input readonly type="text" value="" class="form-control text-3 h-auto py-2" name="email" data-msg-required="Vui lòng nhập email" placeholder="Nhập email" maxlength="255" data-rule-pattern="^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$" data-msg-pattern="Vui lòng nhập email đúng định dạng" required="">
                                </div>
                            </div>
                          
                                  </div>
                             </div>
                         </div>
                         <div class="col-lg-12">
                            <h4 class="text-uppercase text-title-form">Kết quả khám bệnh</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Mã kết quả</th>
                                            <th scope="col">Tên kết quả</th>
                                            <th scope="col">Tệp PDF</th>
                                            <th scope="col">Thời gian tải lên</th>
                                            <th scope="col">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Dòng dữ liệu này có thể được đổ từ database hoặc từ backend -->
                                        <tr>
                                            <td>001</td>
                                            <td>Xét nghiệm máu</td>
                                            <td>
                                                <input type="file" name="result_pdf[]" accept="application/pdf" class="form-control">
                                            </td>
                                            <td>2024-12-16 14:00</td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm">Xóa</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>002</td>
                                            <td>X-Quang phổi</td>
                                            <td>
                                                <input type="file" name="result_pdf[]" accept="application/pdf" class="form-control">
                                            </td>
                                            <td>2024-12-16 15:00</td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm">Xóa</button>
                                            </td>
                                        </tr>
                                        <!-- Các dòng dữ liệu khác -->
                                    </tbody>
                                </table>
                                <button type="submit" name="add_kq" class="btn btn-info">Thêm mới đăng ký thi</button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#bn').change(function() {
                    var bnId = $(this).val();
                    if (bnId != 0) {
                        $.ajax({
                            url: '{{ URL::to('/get-thong-tin-bn/') }}/' + bnId,
                            type: 'GET',
                            dataType: "json",
                            responseType: "json",
                            success: function(data) {
                                var bn = data.bn;
                                var khs = data.kh;
                                var gioiTinh = bn.GioiTinh;
                                $('input[name="hoten"]').val(bn.HoTen);
                                $('input[name="ngaysinh"]').val(bn.NgaySinh);
                                $('input[name="diachi"]').val(bn.DiaChi);
                                $('input[name="sdt"]').val(bn.sdt);
                                $('input[name="email"]').val(khs.email);
                                $('#city option[name="province"]').val(bn.province);
                                $('#city option:selected').text(bn.province);
                                $('#district option[name="district"]').val(bn.district);
                                $('#district option:selected').text(bn.district);
                                $('#ward option[name="ward"]').val(bn.ward);
                                $('#ward option:selected').text(bn.ward);
                                if (gioiTinh === 1) {
                                    $('#1').prop('checked', true);
                                } else {
                                    $('#0').prop('checked', true);
                                }
                            },
                            error: function() {
                                alert('Đã xảy ra lỗi khi lấy thông tin bệnh nhân');
                            }
                        });
                    } else {
                        $('input[name="hoten"]').val('');
                        $('input[name="ngaysinh"]').val('');
                        $('input[name="diachi"]').val('');
                        $('input[name="sdt"]').val('');
                        $('input[name="email"]').val('');
                        $('input[name="gioitinh"]').prop('checked', false);
                        $('#1').val('');
                        $('#0').val('');
                        $('#city option[name="province"]').val('');
                        $('#city option:selected').text('');
                        $('#district option[name="district"]').val('');
                        $('#district option:selected').text('');
                        $('#ward option[name="ward"]').val('');
                        $('#ward option:selected').text('');
                    }
                });
            });
        </script>
@endsection
