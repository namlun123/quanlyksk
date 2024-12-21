@extends('layout')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <div class="container mt-5">
        <div class="row1 justify-content-center">
            <div class="col-lg-8 ">
                <div class="card">
                    <div class=" text-center">
                        <h2>ĐĂNG KÝ TÀI KHOẢN</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('register-kh') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Họ tên</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nhập họ tên">
                            </div>
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email">
                            </div>
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu">
                            </div>
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Nhập lại mật khẩu</label>
                                <input type="password" class="form-control" placeholder="Nhập lại mật khẩu" name="password_confirmed" required>
                            </div>
                        
                            <div class="form-group mb-3">
                                <label for="BirthDay" class="form-label">Ngày sinh</label>
                                <input type="date" class="form-control" id="BirthDay" name="ngaysinh" placeholder="YYYY/MM/DD">
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Giới tính</label>
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gioitinh" id="1" value="1">
                                        <label class="form-check-label" for="1">Nam</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gioitinh" id="0" value="0">
                                        <label class="form-check-label" for="0">Nữ</label>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="form-group mb-3">
                                <label class="form-label mb-1 text-2 required">Số nhà, đường/phố</label>
                                <input type="text" value="" class="form-control text-3 h-auto py-2 " placeholder="Nhập số nhà, đường/phố/phường/quận/thành phố" name="diachi">
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label mb-1 text-2 required" for="city">Tỉnh/Thành phố</label>
                                <select class="form-select form-control h-auto py-2"  id="city" name="province">
                                <option value="province" selected>Chọn Tỉnh/Thành</option>
                            </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label mb-1 text-2 required" for="district">Quận/Huyện</label>
                                <select class="form-select form-control h-auto py-2"  id="district" name="district">

                                    <option value="district" selected>Chọn Quận/Huyện</option>

                            </select>
                            </div>
                            <div class="form-group mb-3">
                            <label class="form-label mb-1 text-2 required" for="ward">Phường/Xã</label>
                            <select class="form-select form-control h-auto py-2" id="ward" name="ward">
                                <option value="ward" selected>Chọn Phường/Xã</option>
                            </select>
                            </div>
                            <div class="form-group mb-3">
                            <label for="sdt" class="form-label">Số điện thoại</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="sdt" 
                                name="sdt" 
                                placeholder="Nhập số điện thoại" 
                                inputmode="numeric" 
                                pattern="[0-9]{10}" 
                                title="Số điện thoại chỉ được chứa 10 chữ số"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)">
                        </div>

                            <div class="form-group form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="terms" checked>
                                <label class="form-check-label" for="terms">Chấp nhận <a href="#">các điều khoản sử dụng</a></label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
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
        </div>
    </div>

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
<style>
/* Reset các thuộc tính mặc định của HTML */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Container chính */
.container {
    max-width: 1200px;
    margin: 0 auto;
}

.row1 {
    display: flex;
    justify-content: center; /* Căn giữa hàng */
    align-items: center; /* Căn giữa các phần tử dọc */
}



/* Hero section */
.untree_co-hero {
    position: relative;
    background-size: cover;
    background-position: center;
    padding: 60px 0;
    color: #fff;
}

.untree_co-hero .heading {
    font-size: 2.5em;
    font-weight: bold;
}

/* Section chính */
.untree_co-section {
    padding: 40px 0;
    background-color: #f9f9f9;
}

.card {
    border: none;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card-header {
    background-color: #007bff;
    color: #fff;
    text-align: center;
    padding: 15px;
    border-radius: 8px 8px 0 0;
}

.card-body {
    padding: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    font-weight: bold;
    margin-bottom: 5px;
    display: block;
}

.form-control {
    width: 100%;
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #ddd;
}

.form-select {
    width: 100%;
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #ddd;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

.form-check {
    display: flex;
    align-items: center;
}

.form-check-input {
    margin-right: 5px;
}

.form-check-label {
    margin: 0;
}

.btn {
    padding: 10px 15px;
    color: #fff;
    background-color: #a5c422;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-align: center;
}

.btn:hover {
    background-color: #0056b3;
}

.text-center {
    text-align: center;
}

.mb-3 {
    margin-bottom: 1rem;
}

.mt-3 {
    margin-top: 1rem;
}

.w-100 {
    width: 100%;
}

.autocomplete {
    position: relative;
}

.autocomplete .autocomplete-suggestions {
    position: absolute;
    background: #fff;
    border: 1px solid #ddd;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    display: none;
}

.autocomplete.active .autocomplete-suggestions {
    display: block;
}
</style>