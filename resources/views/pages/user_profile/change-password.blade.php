<!-- resources/views/change-password.blade.php -->

@extends('layout')

@section('content')
<div class="container py-2">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
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
            <form action="{{ route('user.change.password') }}" method="POST">
                @csrf <!-- Bảo vệ CSRF token -->
                <div class="form-group">
                    <label for="current_password" class="form-label mb-1 text-2"> <span toggle="#current_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>Mật khẩu hiện tại</label>
                    <input type="password" id="current_password" name="current_password" class="form-control text-3 h-auto py-2" required>
                   
                </div>
                <div class="form-group">
                    <label for="new_password" class="form-label mb-1 text-2"><span toggle="#new_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>Mật khẩu mới</label>
                    <input type="password" id="new_password" name="new_password" class="form-control text-3 h-auto py-2" required minlength="6">
                    
                </div>
                <div class="form-group">
                    <label for="new_password_confirmation" class="form-label mb-1 text-2"><span toggle="#new_password_confirmation" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    Xác nhận mật khẩu mới</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control text-3 h-auto py-2" required>
                </div>
                <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
            </form>
        </div>
    </div>
</div>
@endsection

<!-- resources/css/styles.css -->
 <style>
    .row {
    display: flex;
    justify-content: center; /* Căn giữa hàng */
    align-items: center; /* Căn giữa các phần tử dọc */
}
.field-icon {
    cursor: pointer;
    float: right;
    padding-top:5px;
    padding-left: 10px;
}

.field-icon.toggle-password:before {
    content: "\f06e"; /* unicode for eye-slash icon */
}

.field-icon.toggle-password.active:before {
    content: "\f06e"; /* unicode for eye-slash icon */
}

.field-icon.active:before {
    content: "\f070"; /* unicode for eye icon */
}
</style>
<!-- resources/js/custom.js -->
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