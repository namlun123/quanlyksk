@extends('layout')
@section('content')
<!--  -->

<div class="untree_co-section">
    <div class="container">
        <div class="row1 justify-content-center">
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="form-box shadow p-4 rounded bg-white">
                    <h2 class="text-center mb-4">Đăng nhập trang quản trị</h2>
                    <form action="{{ route('admin.loginPost') }}" method="POST" id="admin-login">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="text" id="email" class="form-control" placeholder="Nhập email" name="email">
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Mật khẩu</label>
                            <input type="password" id="password" class="form-control" placeholder="Nhập mật khẩu" name="password">
                        </div>
                        <div class="form-group mb-3 form-check">
                            <input type="checkbox" id="remember" class="form-check-input" name="remember" checked>
                            <label class="form-check-label" for="remember">Nhớ mật khẩu</label>
                        </div>

                        <div class="form-group mb-3 d-flex align-items-center">
                            <div class="me-3">
                                <img src="{{ captcha_src() }}" alt="Captcha" class="img-fluid rounded">
                            </div>
                            <input type="text" name="captcha" class="form-control" placeholder="Nhập captcha" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary1">Đăng nhập</button>
                        </div>
                    </form>

                    @if ($errors->any())
                        <div class="alert alert-danger mt-4">
                            <ul class="mb-0">
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
@endsection

<style>
    .untree_co-hero {
        padding: 100px 0;
    }
    .form-box {
    border: 1px solid #dee2e6;
    border-radius: 10px; /* Bo góc mềm mại */
    background: #f8f9fa; /* Màu nền nhẹ */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Tạo hiệu ứng nổi */
    padding: 20px;
    transition: transform 0.3s, box-shadow 0.3s; /* Hiệu ứng khi hover */
}

.form-box:hover {
    transform: translateY(-5px); /* Nhấn mạnh khi hover */
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.form-box h2 {
    font-size: 3rem;
    font-weight: bold;
    color: #212529; /* Màu chữ đậm hơn */
    margin-bottom: 20px;
    text-align: center; /* Căn giữa tiêu đề */
    text-transform: uppercase; /* Viết hoa */
}

.form-box .form-control {
    height: 50px; /* Tăng chiều cao cho thoáng */
    border-radius: 8px; /* Bo góc mềm hơn */
    border: 1px solid #ced4da; /* Màu viền nhẹ hơn */
    padding: 10px 15px; /* Thêm khoảng trống */
    font-size: 1rem;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1); /* Hiệu ứng trong viền */
    transition: border-color 0.3s, box-shadow 0.3s; /* Hiệu ứng mượt */
}

.form-box .form-control:focus {
    border-color: #007bff; /* Viền khi focus */
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Hiệu ứng phát sáng */
    outline: none; /* Loại bỏ viền mặc định */
}

.btn-primary1 {
    background-color: #a5c422; /* Màu xanh tối hơn */
    color: #fff; /* Chữ màu trắng */
    height: 50px; /* Tăng chiều cao */
    width: 100%;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 25px; /* Nút hình tròn hơn */
    transition: background-color 0.3s, box-shadow 0.3s; /* Hiệu ứng hover */
}

.btn-primary1:hover {
    background-color: #0056b3; /* Màu hover đậm hơn */
    box-shadow: 0 4px 15px rgba(0, 86, 179, 0.4); /* Hiệu ứng nổi */
    transform: scale(1.02); /* Phóng to nhẹ khi hover */
    color: #fff;
}


    .row1 {
    display: flex;
    justify-content: center; /* Căn giữa hàng */
    align-items: center; /* Căn giữa các phần tử dọc */
}
</style>
