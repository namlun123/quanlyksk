@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="row justify-content-start">
        <div class="col-lg-6">
            @if(Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @elseif($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif
            <h4 class="text-uppercase mb-4">ĐỔI MẬT KHẨU</h4>
            <form action="{{ route('admin.change-password.post') }}" method="post">
                @csrf
                <div class="form-group position-relative">
                    <label for="current_password" class="form-label">Mật khẩu cũ</label>
                    <input type="password" id="current_password" name="current_password" class="form-control" required>
                    <span toggle="#current_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                </div>
                <div class="form-group position-relative">
                    <label for="new_password" class="form-label">Mật khẩu mới</label>
                    <input type="password" id="new_password" name="new_password" class="form-control" required>
                    <span toggle="#new_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                </div>
                <div class="form-group position-relative">
                    <label for="new_password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" required>
                    <span toggle="#new_password_confirmation" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                </div>
                <button type="submit" class="btn btn-success btn-block">Đổi mật khẩu</button>
            </form>
        </div>
    </div>
</div>
@endsection


<style>
 /* Style for form container */
.form-group {
    position: relative;
    margin-bottom: 1.5rem;
}

/* Style for input fields */
.form-control {
    padding-right: 40px; /* Để tạo không gian cho icon */
}

/* Style for eye icon */
.field-icon {
    cursor: pointer;
    position: absolute;
    right: 15px; /* Căn vào cuối bên phải của ô nhập liệu */
    top: 70%; /* Đặt ở giữa chiều cao của ô nhập liệu */
    transform: translateY(-50%); /* Dịch chuyển 50% chiều cao của ô nhập liệu để căn giữa */
    color: #007bff; /* Thêm màu cho icon */
}

/* Active state for eye icon */
.field-icon.active:before {
    content: "\f070"; /* Unicode cho biểu tượng con mắt */
}

/* Default state for eye icon (eye-slash) */
.field-icon.toggle-password:before {
    content: "\f06e"; /* Unicode cho biểu tượng mắt bị khóa */
}

/* Optional: improve spacing and look for labels */
label.form-label {
    font-size: 1rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
}


    </style>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
    var fieldIcons = document.querySelectorAll('.toggle-password');

    fieldIcons.forEach(function (icon) {
        icon.addEventListener('click', function () {
            var input = document.querySelector(icon.getAttribute('toggle'));
            if (input.type === "password") {
                input.type = "text";
                icon.classList.add('active');
            } else {
                input.type = "password";
                icon.classList.remove('active');
            }
        });
    });
});

    </script>