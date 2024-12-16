@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1>
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-check-circle text-success" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
                </svg> Đặt hàng thành công
            </h1>
            <span class="text-muted">Mã đơn hàng #DH{{ $enroll->id }}</span>

            <div id="success_pay_box" class="p-2 text-center pt-3 border border-2 mt-5" style="display:none">
                <h2 class="text-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-check-circle text-success" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
                    </svg> Thanh toán thành công
                </h2>
                <p class="text-center text-success">Chúng tôi đã nhận được thanh toán, đơn hàng sẽ được chuyển đến quý khách trong thời gian sớm nhất!</p>
            </div>

            <div class="row mt-5 px-2" id="checkout_box">
                <div class="col-12 text-center my-2 border"><p class="mt-2">Hướng dẫn thanh toán qua chuyển khoản ngân hàng</p></div>
                <div class="col-md-6 border text-center p-2">
                    <p class="fw-bold">Cách 1: Mở app ngân hàng và quét mã QR</p>
                    <div class="my-2">
                        <img src="https://qr.sepay.vn/img?bank=MBBank&acc=0903252427&template=compact&amount={{ intval($enroll->total_cost) }}&des=DH{{ $enroll->id }}" class="img-fluid">
                        <span>Trạng thái: Chờ thanh toán... <div class="spinner-border" role="status"><span class="sr-only"></span></div></span>
                    </div>
                </div>
                <div class="col-md-6 border p-2">
                    <p class="fw-bold">Cách 2: Chuyển khoản thủ công theo thông tin</p>
                    <div class="text-center">
                        <img src="https://qr.sepay.vn/assets/img/banklogo/MB.png" class="img-fluid" style="max-height:50px">
                        <p class="fw-bold">Ngân hàng MBBank</p>
                    </div>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Chủ tài khoản: </td>
                                <td><b>Bùi Tấn Việt</b></td>
                            </tr>
                            <tr>
                                <td>Số TK: </td>
                                <td><b>0903252427</b></td>
                            </tr>
                            <tr>
                                <td>Số tiền: </td>
                                <td><b>{{ number_format($enroll->total_cost) }}đ</b></td>
                            </tr>
                            <tr>
                                <td>Nội dung CK: </td>
                                <td><b>DH{{ $enroll->id }}</b></td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="bg-light p-2">Lưu ý: Vui lòng giữ nguyên nội dung chuyển khoản DH{{ $enroll->id }} để hệ thống tự động xác nhận thanh toán</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
