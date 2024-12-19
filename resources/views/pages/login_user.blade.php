@extends('layout')
@section('content')
    <div class="container">
        <div class="row1 justify-content-center">
            <div class="col-lg-6">
                <div class="login-wrapper">
                    <div class="text-center mb-4">
                        <h1 class="heading text-white" data-aos="fade-up" data-aos-delay="100" style = "font-size: 40px";>ĐĂNG NHẬP TÀI KHOẢN</h1>
                    </div>
                    <form action="{{ route('login-kh') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <input type="email" class="form-control" placeholder="Email" name="email" required>
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" class="form-control" placeholder="Mật khẩu" name="password" required>
                        </div>
            
                        <div class="form-group mb-3">
                            <label class="control control--checkbox">
                                <span class="caption">Nhớ mật khẩu</span>
                                <input type="checkbox" checked>
                                <div class="control__indicator"></div>
                            </label>
                        </div>
                        <div class="form-group mb-3 d-flex align-items-center">
                            <div class="captcha-img">
                                <img src="{{ captcha_src('math') }}" alt="Captcha">
                            </div>
                            <input type="text" name="captcha" class="form-control" placeholder="Nhập Captcha" required>
                        </div>
                        <div class="form-group text-center">
                            <input type="submit" value="Đăng nhập" class="btn btn-primary btn-block">
                        </div>
                    </form>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="error">
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

<style>
    .login-wrapper {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 30px;
        justify-content: center;

    }
    .form-control {
        border-radius: 4px;
        border: 1px solid #ddd;
        padding: 10px;
        font-size: 14px;
    }
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
    }
    .btn-primary {
        background-color: #a5c422;
        border: none;
        color: #fff;
        font-weight: bold;
        padding: 10px;
        border-radius: 4px;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }
    .error {
        color: red;
        text-align: left;
    }
    .row1 {
    display: flex;
    justify-content: center; /* Căn giữa hàng */
    align-items: center; /* Căn giữa các phần tử dọc */
}
</style>
@endsection
