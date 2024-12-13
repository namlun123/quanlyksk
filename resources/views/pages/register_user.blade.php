@extends('layout')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<div class="untree_co-hero inner-page overlay" style="background-image: url('{{ asset('public/frontend/images/home_toeic.jpg') }}');">
    <div class="container">
      <div class="row align-items-center justify-content-center">
        <div class="col-12">
          <div class="row justify-content-center ">
            <div class="col-lg-6 text-center ">
              <h1 class="mb-4 heading text-white" data-aos="fade-up" data-aos-delay="100">Đăng ký</h1>

            </div>
          </div>
        </div>
      </div> <!-- /.row -->
    </div> <!-- /.container -->

  </div> <!-- /.untree_co-hero -->
  <div class="untree_co-section">
    <div class="container">

        <div class="row mb-5 justify-content-center">
            <div class="col-lg-12 mx-auto order-1" data-aos="fade-up" data-aos-delay="200">
                <form action="{{ route('register-kh') }}" class="form-box" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <input type="text" class="form-control" placeholder="Họ tên" name="name">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <input type="text" class="form-control" placeholder="Email" name="email">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <input type="password" class="form-control" placeholder="Mật khẩu" name="password">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <input type="password" class="form-control" placeholder="Nhập lại mật khẩu" name="password_confirmed">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label" class="form-label mb-1 text-2 required">Ngày sinh</label>
                            <div class="input-group">
                                <input type="date" class="form-control text-3 h-auto py-2 type-date" name="ngaysinh" id="BirthDay" placeholder="YYYY/MM/DD">
                                <label class="" for="BirthDay"><i class="fas fa-calendar-alt"></i></label>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label mb-1 text-2 required">Giới tính</label>
                            <div class="col-lg-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gioitinh" id="1" value="1">
                                    <label class="form-check-label" for="1">Nam</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gioitinh" id="0" value="0" >
                                    <label class="form-check-label" for="0">Nữ</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 mb-3">
                            <label class="form-label mb-1 text-2 required">Số nhà, đường/phố</label>
                            <input type="text" value="" class="form-control text-3 h-auto py-2 " placeholder="Nhập số nhà, đường/phố/phường/quận/thành phố" name="diachi">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label mb-1 text-2 required" for="city">Tỉnh/Thành phố</label>
                            <select class="form-select form-control h-auto py-2"  id="city" name="province">
                                <option value="province" selected>Chọn Tỉnh/Thành</option>
                            </select>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label mb-1 text-2 required" for="district">Quận/Huyện</label>
                            <select class="form-select form-control h-auto py-2"  id="district" name="district">

                                <option value="district" selected>Chọn Quận/Huyện</option>

                            </select>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label mb-1 text-2 required" for="ward">Phường/Xã</label>
                            <select class="form-select form-control h-auto py-2" id="ward" name="ward">
                                <option value="ward" selected>Chọn Phường/Xã</option>
                            </select>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label mb-1 text-2 required">Số điện thoại</label>
                            <input class="form-control text-3 h-auto py-2" type="text" name="sdt" placeholder="Nhập số điện thoại">
                        </div>
                        {{-- Thêm các trường khác như giới tính, CCCD, ngày cấp CCCD, nơi cấp, địa chỉ, thành phố, quận, huyện, số điện thoại tại đây --}}
                        <div class="col-12 mb-3">
                            <label class="control control--checkbox">
                                <span class="caption">Chấp nhận <a href="#">các điều khoản sử dụng</a></span>
                                <input type="checkbox" checked="checked" />
                                <div class="control__indicator"></div>
                            </label>
                        </div>
                        <div class="col-12">
                            <input type="submit" value="Đăng ký" class="btn btn-primary">
                        </div>
                    </div>
                </form>

                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
  </div> <!-- /.untree_co-section -->
<script>
    $(document).ready(function(){
        $('#BirthDay').datepicker({
            dateFormat: 'yy/mm/dd', // Định dạng ngày được chọn bởi người dùng
            autoclose: true // Tự động đóng datepicker sau khi chọn ngà
        });
    });
</script>
<script>
    var citis = document.getElementById("city");
    var districts = document.getElementById("district");
    var wards = document.getElementById("ward");

    var Parameter = {
        url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json",
        method: "GET",
        responseType: "json",
    };

    axios(Parameter)
        .then(function (response) {
            renderCity(response.data);
        })
        .catch(function (error) {
            console.log(error);
        });

    function renderCity(data) {
        for (const x of data) {
            citis.options[citis.options.length] = new Option(x.Name, x.Name);
        }
        citis.onchange = function () {
            districts.length = 1;
            wards.length = 1;
            if (this.value != "") {
                const result = data.filter((n) => n.Name === this.value);

                for (const k of result[0].Districts) {
                    districts.options[districts.options.length] = new Option(k.Name, k.Name);
                }
            }
        };
        districts.onchange = function () {
            wards.length = 1;
            const dataCity = data.filter((n) => n.Name === citis.value);
            if (this.value != "") {
                const dataWards = dataCity[0].Districts.filter((n) => n.Name === this.value)[0].Wards;

                for (const w of dataWards) {
                    wards.options[wards.options.length] = new Option(w.Name, w.Name);
                }
            }
        };
    }
</script>
@endsection
