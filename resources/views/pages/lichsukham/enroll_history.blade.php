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
            width: 100%;
            max-width: 95%;
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
        /* Căn chỉnh tổng thể */
body {
    font-family: 'Poppins', Arial, sans-serif;
    background-color: #f8f9fa;
    color: #343a40;
}

/* Header */
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

/* Bảng lịch sử khám */
.table {
    background-color: #ffffff;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    width: 100%; /* Bảng chiếm toàn bộ chiều rộng */
    max-width: 100%;
}

.table th {
    background-color:#a5c422;
    color: #ffffff;
    text-align: center;
    font-weight: bold;
    padding: 12px;
}
.table th,
    .table td {
        white-space: nowrap; /* Giữ nội dung trên một dòng */
        padding: 10px 20px; /* Tăng khoảng cách giữa nội dung và viền */
    }
.table tbody tr:hover {
    background-color: #f1f1f1;
    transition: background-color 0.3s ease;
}

.table td {
    text-align: center;
    vertical-align: middle;
    padding: 10px;
}

.table td span {
    font-size: 14px;
    color: #6c757d;
}

/* Trạng thái thanh toán */
.btn-success {
    background-color: #28a745;
    color: white;
    font-size: 14px;
    border: none;
    border-radius: 4px;
    padding: 8px 12px;
    transition: background-color 0.3s ease;
}

.btn-success:hover {
    background-color: #218838;
}

.text-ellipsis {
    color: #dc3545;
    font-weight: bold;
    font-size: 14px;
}

/* Link PDF */
a {
    color:rgb(147, 187, 229);
    text-decoration: none;
    font-weight: bold;
}

a:hover {
    color: #0056b3;
    text-decoration: underline;
}

/* Phân trang */
.pagination {
    margin: 20px 0;
}

.pagination .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: #ffffff;
}

.pagination .page-link {
    color: #007bff;
    transition: all 0.3s ease;
}

.pagination .page-link:hover {
    background-color: #f1f1f1;
    border-color: #007bff;
}

/* Thông báo */
p.text-center {
    font-size: 16px;
    color: #dc3545;
    margin-bottom: 20px;
}

.star {
    color: #ff4d00;
    font-weight: bold;
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
                                                <h1 style ="color: white";>LỊCH SỬ KHÁM</h1>
                                            </div>
                                    </div>
                                </div>
                            </div>

                </div>
            </div>
        </section>
        @if (session('alert'))
            <div class="alert alert-success">
                {{ session('alert') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-succes">
                {{ session('success') }}
            </div>
        @endif

        <div class="container py-2">
        <!-- <h1 class="text-center text-uppercase color-primary-1">
            Lịch sử thi
        </h1> -->
        <p class="text-center"> <span class="star">*</span> Chú ý: Trạng thái hiện "Đã thanh toán" nghĩa là hoàn tất thủ tục đăng ký khám</p>
        @php
    $id = session('user_id'); // Lấy ID từ session
    $user_id = DB::table('patients')->where('id', $id)->value('user_id');

    $all_infor = DB::table('info_patients')
        ->join('enrolls', 'enrolls.patient_id', '=', 'info_patients.id')
        ->join('patients', 'patients.user_id', '=', 'info_patients.id')
        ->select(
            'enrolls.*',
            'info_patients.*',
            'patients.*',
            'enrolls.specialty_id as chuyenkhoakham',
            'enrolls.id as hoso_id',
            'enrolls.doctor_id as bacsi',
            'enrolls.location_id as noikham',
            'info_patients.id as bn_id',
            'enrolls.date as ngaykham'
        )
        ->where('enrolls.patient_id', $user_id);

    $all_infor = $all_infor->paginate(5); // Phân trang
@endphp

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead>
                <tr  class="text-center table-primary">
                    <th>Mã hồ sơ</th>
                    <th>Họ và tên</th>
                    <th>Chuyên khoa khám</th>
                    <th>Bác sĩ phụ trách</th>
                    <th>Nơi khám</th>
                    <th>Ngày khám</th>
                    <th>Giờ khám</th>
                    <th>Tổng chi phí</th>
                    <th>Trạng thái</th>
                    <th>Kết quả khám</th>
                    <th>Thao tác</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($all_infor as $infor)
                    <tr>
                        <td>{{ $infor->hoso_id}}</td>
                        <td>{{ $infor->HoTen }}</td>
                        <td>@php
                                $chuyenkhoa = DB::table('specialties')->where('specialty_id', $infor->chuyenkhoakham)->first();
                                if($chuyenkhoa) {
                                    echo $chuyenkhoa->specialty;
                                }
                            @endphp</td>
                            <td>@php
                                $bacsi = DB::table('doctors')->where('id', $infor->bacsi)->first();
                                if($bacsi) {
                                    echo $bacsi->HoTen;
                                }
                            @endphp</td>
                        <td>@php
                                $diadiem = DB::table('locations')->where('location_id', $infor->noikham)->first();
                                if($diadiem) {
                                    echo $diadiem->location_address;
                                }
                            @endphp</td>
                        <td>@php
                                $ngaykham = DB::table('enrolls')->where('id', $infor->hoso_id)->first();
                                if($ngaykham) {
                                    echo $ngaykham->date;
                                }
                            @endphp</td>
                            <td>@php
                                $giokham = DB::table('enrolls')->where('id', $infor->hoso_id)->first();
                                if($giokham) {
                                    echo $giokham->time_slot;
                                }
                            @endphp</td>
                        <td>{{ $infor->total_cost }}</td>
                       
                        <td>
                        <span class="text-ellipsis"></span>
                            @php
                            if ($infor->status == 0) {
                            @endphp
                            <form action="{{ route('appointment.payment', ['enroll_id' => $infor->hoso_id]) }}" method="get">
                                <button type="submit" class="btn btn-success">Thanh toán VNPay</button>
                            </form>
                            @php
                                } elseif ($infor->status == 1) {
                            @endphp
                            <span class = "">Đã thanh toán</span>
                            @php
                                } elseif ($infor->status == 2) {
                            @endphp
                                <span style= "color:red;" class="text-danger">Đã hủy</span>

                            @php
                                }
                            @endphp
                        </td>
                        </form>
                        <td>
                        @if ($infor->result_pdf)
                            <!-- Liên kết trực tiếp đến file PDF -->
                            <a href="{{ route('user.showPdf', ['id' => $infor->hoso_id]) }}" target="_blank">Xem PDF</a>
                        @else
                            <span class="text-ellipsis">Chưa có kết quả</span>
                        @endif

                        </td>

                        <td>
                            @php
                                if ($infor->status==0) {
                            @endphp
                            <span><a href="{{ route('appointment.edit', ['id' => $infor->hoso_id]) }}">Sửa / </a>
                            <form action="{{ route('appointment.cancel', ['id' => $infor->hoso_id]) }}" method="POST" id="cancel-form-{{ $infor->hoso_id }}">
                                @csrf
                                @method('POST') <!-- Sử dụng phương thức POST -->
                                <a href="javascript:void(0);" onclick="document.getElementById('cancel-form-{{ $infor->hoso_id }}').submit(); return confirm('Bạn có chắc chắn hủy lịch hẹn không?')">Hủy đăng ký</a>
                            </form>
                            @php
                                } else {
                            @endphp
                            <span class = "text-ellipsis"></span>
                            @php
                                }
                            @endphp
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            {{ $all_infor->appends(request()->all())->links() }}
        </div>
        <h2 id="result"></h2>
    </div> 


    <script type="text/javascript">
    // Hàm ẩn thông báo sau 5 giây
    setTimeout(function() {
        // Tìm tất cả các thông báo và ẩn chúng
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            alert.style.display = 'none';
        });
    }, 4000); // Thời gian là 5 giây (5000 milliseconds)
</script>

@endsection
