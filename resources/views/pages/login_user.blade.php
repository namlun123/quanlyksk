@extends('layout')
@section('content')
<div class="untree_co-hero inner-page overlay" style="background-image: url('{{ asset('public/frontend/images/home_toeic.jpg') }}');">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-lg-6 text-center">
                        <h1 class="mb-4 heading text-white" data-aos="fade-up" data-aos-delay="100">Đăng nhập</h1>
                    </div>
                </div>
            </div>
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</div> <!-- /.untree_co-hero -->

<div class="untree_co-section">
    <div class="container">
        <div class="row mb-5 justify-content-center">
            <div class="col-lg-5 mx-auto order-1" data-aos="fade-up" data-aos-delay="200">
                <form action="{{ route('login-kh') }}" class="form-box" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12 mb-3">
                            <input type="text" class="form-control" placeholder="Email" name="email">
                        </div>
                        <div class="col-12 mb-3">
                            <input type="password" class="form-control" placeholder="Mật khẩu" name="password">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="control control--checkbox">
                                <span class="caption">Nhớ mật khẩu</span>
                                <input type="checkbox" checked="checked">
                                <div class="control__indicator"></div>
                            </label>
                        </div>
                        <div class="col-12 mb-3 d-flex align-items-center">
                            <div class="captcha-img">
                                <img src="{{ captcha_src() }}" alt="Captcha" style="margin-right: 10px;">
                                <!-- <button type="button" class ="btn btn-danger reload" id="reload">&#x21bb;</button> -->
                            </div>
                            <div class="captcha-input">
                                <input type="text" name="captcha" class="form-control" placeholder="Enter Captcha" required>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <input type="submit" value="Đăng nhập" class="btn btn-primary btn-login">
                        </div>
                    </div>
                </form>
                @if ($errors->any())
                    <ul class="error">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div> <!-- /.untree_co-section -->
@endsection

<style>
  .captcha-img {
    margin-right: 10px;
  }
  .captcha-input {
    flex: 1;
  }
  .btn-login {
    width: 50%; /* Chỉnh độ rộng của nút đăng nhập */
    margin: 0 auto; /* Căn giữa nút */
    display: block; /* Đảm bảo nút là một phần tử khối để căn giữa */
  }
  .error {
    color: red;
    text-align: left;
  }
</style>
<!-- <script>
    $('#reload').click(function() {
        $.ajax({
            type:'GET',
            url:'reload-captcha',
            success:function(data){
                $(".captcha span").html(data.captcha)
            }
        });
    });
    </script> -->