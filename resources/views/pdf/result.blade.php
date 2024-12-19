<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kết quả xét nghiệm</title>
    <style>
        body {
            font-family: "DejaVu Sans", sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            padding: 10px 0;
            margin-bottom: 20px;
        }

        .header img {
            max-height: 60px; /* Kích thước logo */
        }

        .header h4, .header p {
            margin: 0;
            padding: 2px 0;
        }

        h1, h2 {
            margin: 0;
            text-align: center;
            padding: 10px 0;
        }

        table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 80%;
        }

        table th, table td {
            text-align: center;
        }

        hr {
            margin: 20px 0;
        }

        p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <!-- Phần header -->
    <div class="header">
        <h4>Bệnh viện Đa khoa HealthCenter</h4>
        <p>Địa chỉ: Số 123, Đường X, Quận Y, Thành phố Z</p>
        <p>Điện thoại: (0123) 456-789</p>
    </div>

    <h1>Thông tin đăng ký khám</h1>
    <p><strong>Mã hồ sơ:</strong> {{ $enroll->id }}</p>
    <p><strong>Họ tên:</strong> {{ $patient->HoTen }}</p>
    <p><strong>Số điện thoại:</strong> {{$patient->sdt}}</p>
    <p><strong>Giới tính:</strong> 
        @if ($patient->GioiTinh == 1)
            Nam
        @elseif ($patient->GioiTinh == 0)
            Nữ
        @else
            Không xác định
        @endif
    </p>
    <p><strong>Ngày khám:</strong> {{ $enroll->date }}</p>
    <hr>
    <h2 style="margin-bottom: 10px;">Kết quả xét nghiệm</h2>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>STT</th>
                <th>Mã xét nghiệm</th>
                <th>Tên xét nghiệm</th>
                <th>Kết quả</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results as $index => $result)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $result->loaixn->xetnghiem_id ?? 'N/A' }}</td>
                    <td>{{ $result->loaixn->tenxn ?? 'N/A' }}</td>
                    <td>{{ $result->ketqua }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
