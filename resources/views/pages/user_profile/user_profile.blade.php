@extends('layout')
@section('content')
    <!-- Bootstrap DatePicker JavaScript -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
            integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js"
            integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type="text/javascript"></script>
    <style>
        .container.py-2 {
            padding-top: 20px;
        }
        .slider .item {
        background-position: inherit;
        background-repeat: no-repeat;
        background-attachment: local;
        background-size: cover;
        height: 450px;
    }

        .card-info {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .card-info:hover {
            transform: translateY(-10px);
        }

        .card-info .card-img-top {
            width: 100%;
            height: auto;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .card-info .card-body {
            padding: 20px;
        }

        .card-info h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .card-info .item-tag {
            background-color: #f4f4f4;
            color: #555;
            font-size: 12px;
            margin-bottom: 10px;
            padding: 5px 10px;
            border-radius: 15px;
        }

        .card-info .card-text {
            font-size: 14px;
            line-height: 1.5;
        }

        .line-info {
            margin-top: 20px;
        }

        .btn.bg-color-primary-1 {
            background-color: #ff4d00 !important;
            color: #fff !important;
            border-color: #ff4d00 !important;
        }

        .btn.bg-color-primary-1:hover {
            background-color: #ff3b00 !important;
            border-color: #ff3b00 !important;
        }

        /* Cân chỉnh kích thước của các ô card trong cùng một hàng */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-left: -15px;
            margin-right: -15px;
            justify-content: center; /* Căn giữa hàng */
            align-items: center; /* Căn giữa các phần tử dọc */
        }

        .col-md-6 {
            flex: 1;
            padding: 0 15px;
            margin-bottom: 30px; /* Để chúng cách nhau 30px */
        }
        .btn-primary {
            background-color: #a5c422;
            border: none;
        }
        .slider .item {
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    height: 450px;
}

.slider .caption h1 {
    font-size: 50px;
    color: #ffffff;
    font-weight: bold;
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
    text-align: center;
    margin-bottom: 10px;
}

.slider .caption h3 {
    font-size: 24px;
    color: #dddddd;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
    text-align: center;
}

    </style>
    <section id="home" class="slider" data-stellar-background-ratio="0.5">
            <div class="container">
                <div class="row">
                            <div class="owl-carousel owl-theme">
                                <div class="item item-first">
                                    <div class="caption">
                                            <div class="col-md-offset-1 col-md-10">
                                                <h3>Let's make your life happier</h3>
                                                <h1 style ="color: white";>THÔNG TIN BỆNH NHÂN</h1>
                                            </div>
                                    </div>
                                </div>
                            </div>

                </div>
            </div>
        </section>
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <div class="container py-2">
        @php
            $all_infor = DB::table('info_patients')->where('id', $user->user_id)->get();
        @endphp

        <form action="{{ route('user.update.profile', $user->id) }}" method="post">
            @csrf
        @foreach($all_infor as $infor)
            <div class="col-lg-center">
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label class="form-label mb-1 text-2 required">Họ và tên bệnh nhân</label>
                        <input type="text" value="{{$infor->HoTen}}" class="form-control text-3 h-auto py-2" name="hoten" placeholder="Nhập họ và tên bệnh nhân">
                    </div>

                    <div class="form-group col-lg-6">
                        <label class="form-label mb-1 text-2 required">Ngày sinh</label>
                        <div class="input-group">
                            <input type="date" class="form-control text-3 h-auto py-2 type-date"
                                   name="ngaysinh" id="BirthDay" placeholder="YYYY/MM/DD" value="{{$infor->NgaySinh}}" >
                            <label class="input-group-text" for="BirthDay"><i
                                    class="fas fa-calendar-alt"></i></label>

                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                                <label class="form-label">Giới tính</label>
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gioitinh" id="1" value="1" {{ $infor->GioiTinh == '1' ? 'checked':''  }} >
                                        <label class="form-check-label" for="1">Nam</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gioitinh" id="0" value="0" {{ $infor->GioiTinh == '0' ? 'checked':'' }} >
                                        <label class="form-check-label" for="0">Nữ</label>
                                    </div>
                                </div>
                            </div>

                <div class="row form-group">
                <label class="fw-bold fst-italic col-lg-12" >Địa chỉ liên hệ </label>
                    <br>
                    <label class="fw-bold fst-italic col-lg-12" style ="font-weight: normal;font-style:italic";>(Vui lòng ghi đầy đủ tỉnh/thành phố,
                        huyện/quận, xã/phường, số nhà, đường/phố)</label>
                    <br>
                </div>

                <div class="row">
                    <div class="form-group col-lg-12">
                        <label class="form-label mb-1 text-2 required">Số nhà, đường/phố</label>
                        <input type="text" value="{{$infor->DiaChi}}" class="form-control text-3 h-auto py-2 "
                               placeholder="Nhập số nhà, đường/phố/phường/quận/thành phố" name="diachi">
                    </div>
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
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label class="form-label mb-1 text-2 required">Số điện thoại</label>
                        <input class="form-control text-3 h-auto py-2" type="text" name="sdt"
                               placeholder="Nhập số điện thoại" value="{{$infor->sdt}}">
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="form-label mb-1 text-2 required">Email</label>
                        <input value="{{$user->email}}" class="form-control text-3 h-auto py-2"
                               name="email"
                               placeholder="Nhập email">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col text-center">
                        <button type="submit" id="SubmitProfile" class="btn btn-primary"
                                data-loading-text="<i class='fa fa-spinner fa-spin '></i> Loading..."
                                style="align-items:center;">
                            <div class="text-button">
                                Sửa thông tin
                            </div>
                        </button>
                        <button type="button" id="SubmitProfile" class="btn btn-primary"
                                data-loading-text="<i class='fa fa-spinner fa-spin '></i> Loading..."
                                onclick="window.location.href = '{{ route('show.change.password') }}';">
                            <div class="text-button">
                                Đổi mật khẩu
                            </div>
                        </button>
                        
                      
                    </div>
                </div>
            </div>
            @endforeach
        </form>
                <h2 id="result"></h2>
    </div>

{{--        <script>--}}
{{--            var citis = document.getElementById("city");--}}
{{--            var districts = document.getElementById("district");--}}
{{--            var wards = document.getElementById("ward");--}}

{{--            var Parameter = {--}}
{{--                url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json",--}}
{{--                method: "GET",--}}
{{--                responseType: "json",--}}
{{--            };--}}

{{--            axios(Parameter)--}}
{{--                .then(function (response) {--}}
{{--                    renderCity(response.data);--}}
{{--                })--}}
{{--                .catch(function (error) {--}}
{{--                    console.log(error);--}}
{{--                });--}}

{{--            function renderCity(data) {--}}
{{--                for (const x of data) {--}}
{{--                    citis.options[citis.options.length] = new Option(x.Name, x.Name);--}}
{{--                }--}}
{{--                citis.onchange = function () {--}}
{{--                    districts.length = 1;--}}
{{--                    wards.length = 1;--}}
{{--                    if (this.value != "") {--}}
{{--                        const result = data.filter((n) => n.Name === this.value);--}}

{{--                        for (const k of result[0].Districts) {--}}
{{--                            districts.options[districts.options.length] = new Option(k.Name, k.Name);--}}
{{--                        }--}}
{{--                    }--}}
{{--                };--}}
{{--                districts.onchange = function () {--}}
{{--                    wards.length = 1;--}}
{{--                    const dataCity = data.filter((n) => n.Name === citis.value);--}}
{{--                    if (this.value != "") {--}}
{{--                        const dataWards = dataCity[0].Districts.filter((n) => n.Name === this.value)[0].Wards;--}}

{{--                        for (const w of dataWards) {--}}
{{--                            wards.options[wards.options.length] = new Option(w.Name, w.Name);--}}
{{--                        }--}}
{{--                    }--}}
{{--                };--}}
{{--            }--}}
{{--        </script>--}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var citis = document.getElementById("city");
            var districts = document.getElementById("district");
            var wards = document.getElementById("ward");

            var userProvince = "{{ $infor->province }}";
            var userDistrict = "{{ $infor->district }}";
            var userWard = "{{ $infor->ward }}";

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
                    let option = new Option(x.Name, x.Name);
                    if (x.Name === userProvince) {
                        option.selected = true;
                    }
                    citis.options[citis.options.length] = option;
                }
                if (userProvince) {
                    const result = data.filter((n) => n.Name === userProvince);
                    renderDistrict(result[0].Districts, userDistrict);
                }

                citis.onchange = function() {
                    clearOptions(districts);
                    clearOptions(wards);
                    if (this.value != "") {
                        const result = data.filter((n) => n.Name === this.value);
                        renderDistrict(result[0].Districts);
                    }
                };

                districts.onchange = function() {
                    clearOptions(wards);
                    if (this.value != "") {
                        const dataCity = data.filter((n) => n.Name === citis.value);
                        const dataWards = dataCity[0].Districts.filter((n) => n.Name === this.value)[0].Wards;
                        renderWard(dataWards);
                    }
                };
            }

            function renderDistrict(districtsData, selectedDistrict = null) {
                clearOptions(districts);
                for (const k of districtsData) {
                    let option = new Option(k.Name, k.Name);
                    if (k.Name === selectedDistrict) {
                        option.selected = true;
                    }
                    districts.options[districts.options.length] = option;
                }
                if (selectedDistrict) {
                    const result = districtsData.filter((n) => n.Name === selectedDistrict);
                    renderWard(result[0].Wards, userWard);
                }
            }

            function renderWard(wardsData, selectedWard = null) {
                clearOptions(wards);
                for (const w of wardsData) {
                    let option = new Option(w.Name, w.Name);
                    if (w.Name === selectedWard) {
                        option.selected = true;
                    }
                    wards.options[wards.options.length] = option;
                }
            }

            function clearOptions(selectElement) {
                selectElement.length = 1; // Clear all options except the first one
            }
        });

    </script>
@endsection
