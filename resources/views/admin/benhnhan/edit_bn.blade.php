@extends('layouts.admin')
@section('content')
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
                <form action="{{ route('admin.update.bn', ['id' => $bn->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                <div class="container">
                        <div class="text-title-form text-center" >THÔNG TIN BỆNH NHÂN</div>
                        <form>
                            <div class="form-group">
                                <label for="name">Họ và tên</label>
                                <input type="text" id="name" value="{{ $bn->HoTen }}" name="hoten" placeholder="Nhập họ và tên" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="dob">Ngày sinh</label>
                                <input type="date" id="dob" value="{{ $bn->NgaySinh }}" name="ngaysinh" id="Day1" placeholder="DD/MM/YYYY" required="" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Giới tính</label>
                                <div class="form-check">
                                    <input type="radio" value="1" name="gioitinh" id="male" class="form-check-input" {{ $bn->GioiTinh == 1 ? 'checked' : '' }} >
                                    <label for="male">Nam</label>
                                    <input type="radio" value="0" name="gioitinh" id="female" class="form-check-input" {{ $bn->GioiTinh == 0 ? 'checked' : '' }} >
                                    <label for="female">Nữ</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address">Địa chỉ nơi ở</label>
                                <input type="text" id="diachi" name ="diachi" value="{{ $bn->DiaChi }}" class="form-control" placeholder="Nhập địa chỉ ở">
                            </div>

                            <div class="form-group">
                                <label for="city">Tỉnh/Thành phố</label>
                                <select id="city" name="province" class="form-select">
                                    <option>Chọn Tỉnh/Thành phố</option>
                                </select>
                            </div>

                            <!-- Dropdown Quận/Huyện -->
                            <div class="form-group">
                                <label for="district">Quận/Huyện</label>
                                <select id="district" name="district" class="form-select">
                                    <option>Chọn Quận/Huyện</option>
                                </select>
                            </div>

                            <!-- Dropdown Phường/Xã -->
                            <div class="form-group">
                                <label for="ward">Phường/Xã</label>
                                <select id="ward" name="ward" class="form-select">
                                    <option>Chọn Phường/Xã</option>
                                </select>
                            </div>
                            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
                            <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                const selectedCity = "{{ $bn->province }}";   // Giá trị đã chọn từ database
                                const selectedDistrict = "{{ $bn->district }}";
                                const selectedWard = "{{ $bn->ward }}";

                                const cityDropdown = document.getElementById("city");
                                const districtDropdown = document.getElementById("district");
                                const wardDropdown = document.getElementById("ward");

                                // Gọi API và render dữ liệu cho dropdown
                                axios({
                                    url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json",
                                    method: "GET",
                                    responseType: "json",
                                })
                                    .then(function (response) {
                                        const data = response.data;

                                        // 1. Render Thành phố
                                        renderDropdown(data, cityDropdown, selectedCity);

                                        // 2. Xử lý khi Thành phố thay đổi
                                        cityDropdown.addEventListener("change", function () {
                                            const cityName = cityDropdown.value;
                                            const cityData = data.find((city) => city.Name === cityName);

                                            // Xóa dropdown Quận/Huyện và Phường/Xã cũ
                                            resetDropdown(districtDropdown, "Chọn Quận/Huyện");
                                            resetDropdown(wardDropdown, "Chọn Phường/Xã");

                                            if (cityData) {
                                                renderDropdown(cityData.Districts, districtDropdown, null);
                                            }
                                        });

                                        // 3. Xử lý khi Quận/Huyện thay đổi
                                        districtDropdown.addEventListener("change", function () {
                                            const cityName = cityDropdown.value;
                                            const cityData = data.find((city) => city.Name === cityName);
                                            const districtName = districtDropdown.value;

                                            const districtData = cityData?.Districts.find(
                                                (district) => district.Name === districtName
                                            );

                                            // Xóa dropdown Phường/Xã cũ
                                            resetDropdown(wardDropdown, "Chọn Phường/Xã");

                                            if (districtData) {
                                                renderDropdown(districtData.Wards, wardDropdown, null);
                                            }
                                        });

                                        // 4. Gán giá trị ban đầu cho Quận/Huyện và Phường/Xã
                                        if (selectedCity) {
                                            const cityData = data.find((city) => city.Name === selectedCity);
                                            if (cityData) {
                                                renderDropdown(cityData.Districts, districtDropdown, selectedDistrict);

                                                if (selectedDistrict) {
                                                    const districtData = cityData.Districts.find(
                                                        (district) => district.Name === selectedDistrict
                                                    );
                                                    if (districtData) {
                                                        renderDropdown(districtData.Wards, wardDropdown, selectedWard);
                                                    }
                                                }
                                            }
                                        }
                                    })
                                    .catch(function (error) {
                                        console.error("Lỗi khi gọi API:", error);
                                    });

                                // Hàm render dropdown
                                function renderDropdown(data, dropdown, selectedValue) {
                                    for (const item of data) {
                                        const isSelected = item.Name === selectedValue;
                                        const option = new Option(item.Name, item.Name, isSelected, isSelected);
                                        dropdown.appendChild(option);
                                    }
                                }

                                // Hàm reset dropdown
                                function resetDropdown(dropdown, placeholder) {
                                    dropdown.innerHTML = `<option>${placeholder}</option>`;
                                }
                            });

                            </script>
                            <div class="form-group">
                                <label for="phone">Số điện thoại</label>
                                <input type="text"  value="{{ $bn->sdt }}" name ="sdt" placeholder="Nhập số điện thoại" min_length="1" max_length="10" class="form-control">
                            </div>

                            <div class="btn-container">
                            <button type="submit" class="btn btn-info">Cập nhật thông tin</button>
                            </div>                      
                        </form>
                    </div>
</form>
            </div>
        </div>
    </div>
</div>
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