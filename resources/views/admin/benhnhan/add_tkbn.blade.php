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
    <div class="mb-4">
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
                <form action="{{ route('admin.save.tkbn') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg-6">
                        <h4 class="text-uppercase text-title-form">THÔNG TIN TÀI KHOẢN</h4>
                        <div class="form-group col-lg-12">
                            <div class="form-group col-lg-6">
                                <label class="form-label mb-1 text-2 required">Email</label>
                                <input type="text" value="" class="form-control text-3 h-auto py-2" name="email" data-msg-required="Vui lòng nhập Email" placeholder="Nhập Email" maxlength="255" data-rule-pattern="^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$" data-msg-pattern="Vui lòng nhập email đúng định dạng" required="">
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="form-label mb-1 text-2 required">Mật khẩu</label>
                                <input type="password" class="form-control text-3 h-auto py-2" placeholder="Nhập mật khẩu" name="password" min_length="1" max_length="10">
                            </div>
                        </div>
                        <div class="form-group col-lg-12">
                            <div class="form-group col-lg-6">
                                <label class="form-label mb-1 text-2 required">Họ và tên</label>
                                <input type="text" name="hoten" value="" class="form-control text-3 h-auto py-2" placeholder="Nhập họ và tên">
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="form-label mb-1 text-2 required">Ngày sinh</label>
                                <input type="date" class="form-control text-3 h-auto py-2 type-date" name="ngaysinh" id="Day1" placeholder="DD/MM/YYYY" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group col-lg-12">
                                <label class="form-label mb-1 text-2 required">Giới tính</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gioitinh" id="gioitinhNam" value="1" checked>
                                    <label class="form-check-label" for="gioitinhNam">Nam</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gioitinh" id="gioitinhNu" value="0">
                                    <label class="form-check-label" for="gioitinhNu">Nữ</label>
                                </div>
                            </div>
                            
                        </div>
                        <!-- Các trường dữ liệu khác -->
                        <div class="form-group">
                            <div class="form-group col-lg-6">
                                <label class="form-label mb-1 text-2 required">Địa chỉ ở</label>
                                <input type="text" name="diachi" value="" class="form-control text-3 h-auto py-2" placeholder="Nhập địa chỉ ở">
                            </div>
                            <div class="form-group row">
                                    <div class="form-group col-lg-4">
                                        <label class="form-label mb-1 text-2 required" for="city">Tỉnh/Thành phố</label>
                                        <select class="form-select form-control h-auto py-2" id="city" name="province">
                                            <option value="">Chọn Tỉnh/Thành phố</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label class="form-label mb-1 text-2 required" for="district">Quận/Huyện</label>
                                        <select class="form-select form-control h-auto py-2" id="district" name="district">
                                            <option value="">Chọn Quận/Huyện</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label class="form-label mb-1 text-2 required" for="ward">Phường/Xã</label>
                                        <select class="form-select form-control h-auto py-2" id="ward" name="ward">
                                            <option value="">Chọn Phường/Xã</option>
                                        </select>
                                    </div>
                                </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <label class="form-label mb-1 text-2 required">Số điện thoại</label>
                                <input type="text" name="sdt" value="" class="form-control text-3 h-auto py-2" placeholder="Nhập số điện thoại" min_length="1" max_length="10">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" name="add_tkthisinh" class="btn btn-info">Thêm mới thí sinh</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
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
        .then(function(response) {
            renderCity(response.data);
        })
        .catch(function(error) {
            console.log(error);
        });

    function renderCity(data) {
        for (const x of data) {
            citis.options[citis.options.length] = new Option(x.Name, x.Name);
        }

        // Gán sự kiện onchange cho select box của tỉnh/thành phố (city)
        citis.onchange = function() {
            districts.length = 1;
            wards.length = 1;
            if (this.value != "") {
                const result = data.filter(n => n.Name === this.value);
                
                // Kiểm tra xem có quận/huyện nào được trả về từ API hay không
                if (result.length > 0 && result[0].Districts.length > 0) {
                    for (const k of result[0].Districts) {
                        districts.options[districts.options.length] = new Option(k.Name, k.Name);
                    }
                } else {
                    // Nếu không có quận/huyện được trả về, có thể cần kiểm tra API hoặc cấu trúc dữ liệu
                    console.log("Không có quận/huyện được trả về");
                }
            }
        };
        districts.onchange = function() {
            wards.length = 1;
            if (this.value != "") {
                const cityName = citis.value;
                const result = data.filter(n => n.Name === cityName);
                if (result.length > 0 && result[0].Districts.length > 0) {
                    const districtName = this.value;
                    const districtInfo = result[0].Districts.find(district => district.Name === districtName);
                    if (districtInfo && districtInfo.Wards.length > 0) {
                        for (const ward of districtInfo.Wards) {
                            wards.options[wards.options.length] = new Option(ward.Name, ward.Name);
                        }
                    } else {
                        console.log("Không có phường/xã được trả về");
                    }}
                }
            }
    }
</script>

@endsection
