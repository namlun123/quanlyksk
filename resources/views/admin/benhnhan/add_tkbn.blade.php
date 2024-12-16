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
                    <div class="container">
                        <div class="text-title-form text-center" >THÔNG TIN TÀI KHOẢN BỆNH NHÂN</div>
                        <form >
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" id="email" name="email" class="form-control" data-msg-required="Vui lòng nhập Email" placeholder="Nhập Email" maxlength="255" data-rule-pattern="^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$" data-msg-pattern="Vui lòng nhập email đúng định dạng" required="">
                            </div>

                            <div class="form-group">
                                <label for="password">Mật khẩu</label>
                                <input type="password" id="password" name="password" class="form-control" min_length="1" max_length="10">
                            </div>

                            <div class="form-group">
                                <label for="name">Họ và tên</label>
                                <input type="text" id="name" name="hoten" placeholder="Nhập họ và tên" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="dob">Ngày sinh</label>
                                <input type="date" id="dob" name="ngaysinh" id="Day1" placeholder="DD/MM/YYYY" required="" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Giới tính</label>
                                <div class="form-check">
                                    <input type="radio" value="1" name="gioitinh" id="male" class="form-check-input">
                                    <label for="male">Nam</label>
                                    <input type="radio" value="0" name="gioitinh" id="female" class="form-check-input">
                                    <label for="female">Nữ</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address">Địa chỉ nơi ở</label>
                                <input type="text" id="diachi" name ="diachi" class="form-control" placeholder="Nhập địa chỉ ở">
                            </div>

                            <div class="form-group">
                                <label for="city">Tỉnh/Thành phố</label>
                                <select id="city" name="province" class="form-select">
                                    <option>Chọn Tỉnh/Thành phố</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="district">Quận/Huyện</label>
                                <select id="district" class="form-select" id="district" name="district" >
                                    <option>Chọn Quận/Huyện</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="ward">Phường/Xã</label>
                                <select id="ward" name="ward" class="form-select">
                                    <option>Chọn Phường/Xã</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="phone">Số điện thoại</label>
                                <input type="text" name ="sdt" placeholder="Nhập số điện thoại" min_length="1" max_length="10" class="form-control">
                            </div>

                            <div class="btn-container">
                            <button type="submit" class="btn btn-info">Thêm mới thí sinh</button>
                            </div>                      
                        </form>
                    </div>

                
                    <!-- <div class="col-lg-6">
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
                        <!- Các trường dữ liệu khác --
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
                    </div> -->
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
<style>
/* Chỉnh form container */
.container {
    background-color: #f8f9fa;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 20px;
    max-width: 800px; /* Giới hạn chiều rộng */
    margin: 0 auto; /* Căn giữa form */
}

/* Tiêu đề form */
.text-title-form {
    font-size: 1.6rem;
    font-weight: 600;
    color: #2c3e50;
    border-bottom: 2px solid #910734;
    margin-bottom: 20px;
    padding-bottom: 10px;
}

/* Chỉnh các form-group để canh đều hàng */
.form-group {
    display: flex;
    align-items: center; /* Canh giữa theo chiều dọc */
    margin-bottom: 15px;
}

.form-group label {
    flex: 0 0 150px; /* Đặt kích thước cố định cho label */
    font-weight: 600;
    color: #495057;
}

.form-group input, 
.form-group select {
    flex: 1; /* Để input tự mở rộng chiếm phần còn lại */
    padding: 8px 12px;
    border: 1px solid #ced4da;
    border-radius: 5px;
    transition: border-color 0.3s;
}

.form-group input:focus, 
.form-group select:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
    outline: none;
}

/* Chỉnh radio button */
.form-check {
    display: flex;
    align-items: center;
}

.form-check label {
    margin-left: 5px;
    color: #495057;
}

/* Nút thêm mới */
.btn-info {
    background-color:rgba(153, 41, 41, 0.77) !important;
    border: none !important;
    padding: 10px 20px;
    color: #fff;
    font-weight: 600;
    transition: background-color 0.3s;
}

.btn-info:hover {
    background-color:rgba(199, 55, 91, 0.93) !important;
}
.btn-container {
    display: flex;
    justify-content: center; /* Căn giữa theo chiều ngang */
    margin-top: 20px;
}

</style>