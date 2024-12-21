<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Xác Nhận Đăng ký Lịch hẹn</title>
</head>
<body>
    <h2>Xin chào {{ $patient_name }}</h2>
    <p>Quý khách đã đặt lịch đăng ký lịch hẹn thành công với thông tin sau:</p>
    <ul>
        <li><strong>Mã lịch hẹn:</strong> {{ $id }}</li>
        <li><strong>Địa điểm:</strong> {{ $location_name }}</li>
        <li><strong>Chuyên khoa:</strong> {{ $specialty }}</li>
        <li><strong>Bác sĩ:</strong> {{ $doctor_name }}</li>
        <li><strong>Ngày:</strong> {{ $date }}</li>
        <li><strong>Giờ:</strong> {{ $time_slot }}</li>        
        <li><strong>Chi phí:</strong> {{ number_format($total_cost, 0, ',', '.') }} VNĐ</li>
    </ul>
    <p>Vui lòng đến trước giờ khám 10 phút và sử dụng QR bên dưới để check-in tại quầy lễ tân.</p>
    <img src="cid:qrcode.png" alt="Mã QR" />
    <p>Hệ thống chăm sóc sức khỏe HeathCare xin cảm ơn!</p>
</body>
</html>
