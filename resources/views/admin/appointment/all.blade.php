@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>

/* Phần header */
h1 {
    font-size: 24px;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
    text-align: center;
}

/* Phần bảng danh sách lịch khám */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

table th,
table td {
    padding: 10px !important;
    text-align: left;
    font-size: 14px;
    border: 1px solid #ddd;
}

.table-header th {
    background-color:rgba(153, 41, 41, 0.77);
    color: white !important; /* Màu chữ trắng */
    font-weight: bold;
    text-align: center; /* Căn giữa theo chiều ngang */
    vertical-align: middle; /* Căn giữa theo chiều dọc */
    padding: 12px 15px; /* Đảm bảo đủ không gian cho các ô */
}

table td {
    background-color: #f9f9f9;
    color: #333;
}

table tr:nth-child(even) {
    background-color: #f2f2f2;
}

table tr:hover {
    background-color: #e6e6e6;
}

/* Phân trang */
.pagination-container {
    display: flex;
    justify-content: center; /* Căn giữa các phần tử phân trang */
    margin-top: 20px;
}

.pagination {
    display: inline-flex; /* Hiển thị các phần tử phân trang theo dạng dòng ngang */
    list-style: none;
    padding: 0;
    margin: 0;
}

.pagination a {
    display: inline-block;
    padding: 8px 12px;
    margin: 0 5px;
    background-color: #f1f1f1;
    color: #333;
    border-radius: 5px;
    text-decoration: none;
    font-size: 14px;
    border: 1px solid #ddd;
    transition: background-color 0.3s, color 0.3s;
}

.pagination a:hover {
    background-color: #b03a2e;
    color: white;
}

.pagination .active {
    color: white;
}

.pagination .disabled {
    color: #ccc;
    pointer-events: none;
}

.pagination .disabled a {
    background-color: #f1f1f1;
    color: #ccc;
    cursor: not-allowed;
}

/* Ẩn các phần tử phân trang khi có dấu "..." */
.pagination .ellipsis {
    cursor: default;
    padding: 8px 12px;
    background-color: transparent;
    color: #333;
    font-size: 14px;
    border: none;
}


table td:last-child {
    display: flex;
    justify-content: space-around; /* Căn đều các nút */
    align-items: center;
}

/* Các nút thao tác dạng icon */
.actions {
    display: flex;
    flex-direction: column;  /* Sắp xếp các nhóm nút theo chiều dọc (2 dòng) */
    gap: 10px;  /* Khoảng cách giữa các nhóm */
    align-items: center;  /* Căn giữa các nhóm */
}

.action-line {
    display: flex;
    gap: 10px;  /* Khoảng cách giữa các nút trong cùng 1 dòng */
    justify-content: center;  /* Căn giữa các nút trong dòng */
}

.btn-icon {
    padding: 8px;
    font-size: 18px;
    color: white;
    border-radius: 50%;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 40px; /* Giới hạn kích thước nút */
    height: 40px;
    display: inline-flex;
    justify-content: center;
    align-items: center;
}

.btn-icon:hover {
    background-color:rgb(247, 132, 132);
}

.btn-icon:focus {
    outline: none;
}

.btn-edit {
    background: #1e7e34; /* Màu xanh cho Sửa */
}

.btn-delete {
    background: #d9534f; /* Màu đỏ cho Xóa */
}

.btn-print {
    background: #f39c12; /* Màu vàng cho In phiếu */
}

.btn-payment {
    background: #007bff; /* Màu xanh dương cho Thanh toán */
}

/* Biểu tượng cho các nút */
.btn-edit:before {
    content: '\270E'; /* Biểu tượng bút chì */
    font-family: "Arial", sans-serif;
}

.btn-delete:before {
    content: '\1F5D1'; /* Biểu tượng thùng rác */
    font-family: "Arial", sans-serif;
}

.btn-print:before {
    content: '\1F5A8'; /* Biểu tượng máy in */
    font-family: "Arial", sans-serif;
}

.btn-payment:before {
    content: '\1F4B5'; /* Biểu tượng tiền (Dollar) */
    font-family: "Arial", sans-serif;
}

/* Đảm bảo các nút cùng dòng */
.actions {
    display: flex;
    align-items: center; /* Đảm bảo các nút căn chỉnh theo chiều dọc */
    gap: 10px; /* Khoảng cách giữa các nút */
}



/* Phần filter */
.filter-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* Định dạng khi tìm kiếm có kết quả */
.filter-form {
    background-color: #f9f9f9;
    padding: 15px 15px 0px;
    border-radius: 8px;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-wrap: wrap;
    margin-bottom: 15px;
}

.filter-row {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    width: 100%;
    margin-bottom: 20px;
}

.filter-group {
    flex: 1 1 30%;
    min-width: 220px;
}

.filter-group label {
    font-weight: bold;
    margin-bottom: 5px;
    font-size: 14px;
}

.filter-group input,
.filter-group select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    box-sizing: border-box;
}
/* Lớp cha để chứa các nút */
.filter-button-container {
    display: flex;
    justify-content: flex-end;
    gap: 10px; /* Khoảng cách giữa các nút */
}

.filter-button-container {
    width: 100%;
    text-align: center;
}

.filter-button {
    padding: 8px 15px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    width: 100%;
    max-width: 100px;
    margin-top: 10px;
}

.filter-button:hover {
    background-color: #218838;
}

/* Responsive design */
@media (max-width: 768px) {
    .filter-group {
        flex: 1 1 100%;
    }
}

/* Phần nút sửa và xóa */
button {
    padding: 5px 10px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
}

button[type="submit"] {
    color: white;
}

button[type="submit"]:hover {
    background-color: #c0392b;
}

a {
    color: #3498db;
    text-decoration: none;
    font-weight: bold;
}

a:hover {
    text-decoration: underline;
}

/* Cải thiện form tìm kiếm */
.filter-container {
    margin-bottom: 20px;
}

.filter-row {
    margin-bottom: 20px;
}

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fff;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        text-align: center;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    @media print {
        .modal-content {
            box-shadow: none;
            padding: 10px;
            width: 100%;
            font-size: 12px;
        }

        .close, #printButton {
            display: none;
        }

        .modal {
            display: block;
        }
    }

    .modal-content p {
        font-size: 14px;
        margin: 5px 0;
    }



</style>

    <h1 class="text-center">DANH SÁCH ĐĂNG KÝ KHÁM</h1>

    <div class="filter-container">
    <form method="GET" action="{{ route('admin.appointment.all') }}" class="filter-form">
        <div class="filter-row">
            <div class="filter-group">
            <label for="search">Tìm kiếm theo tên hoặc số điện thoại:</label>
                <input type="text" name="search" id="search" value="{{ request()->get('search') }}" placeholder="Nhập tên bệnh nhân hoặc số điện thoại">
            </div>
            <div class="filter-group">
                <label for="status">Trạng thái:</label>
                <select name="status" id="status">
                    <option value="">Tất cả</option>
                    <option value="0" {{ request()->get('status') == '0' ? 'selected' : '' }}>Chưa thanh toán</option>
                    <option value="1" {{ request()->get('status') == '1' ? 'selected' : '' }}>Đã thanh toán</option>
                    <option value="2" {{ request()->get('status') == '2' ? 'selected' : '' }}>Đã hủy</option>
                </select>
            </div>
        </div>

        <div class="filter-row">
            <div class="filter-group">
                <label for="doctor_id">Chọn bác sĩ:</label>
                <select name="doctor_id" id="doctor_id">
                    <option value="">Tất cả</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ request()->get('doctor_id') == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->HoTen }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label for="location_id">Chọn địa điểm:</label>
                <select name="location_id" id="location_id">
                    <option value="">Tất cả</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->location_id }}" {{ request()->get('location_id') == $location->location_id ? 'selected' : '' }}>
                            {{ $location->location_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label for="specialty_id">Chọn chuyên khoa:</label>
                <select name="specialty_id" id="specialty_id">
                    <option value="">Tất cả</option>
                    @foreach($specialties as $specialty)
                        <option value="{{ $specialty->specialty_id }}" {{ request()->get('specialty_id') == $specialty->specialty_id ? 'selected' : '' }}>
                            {{ $specialty->specialty }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <!-- Các nút trên cùng một dòng -->
        <div class="filter-row">
            <div class="filter-button-container">
                <button type="button" class="filter-button" onclick="openQrModal()">Quét QR</button>
                <button type="submit" class="filter-button">Tìm kiếm</button>
            </div>
        </div>
    </form>
    <div class="appointment-table">
        <table border="1" cellpadding="10" cellspacing="0" class="table">
            <thead>
                <tr class="table-header">
                    <th>ID</th>
                    <th>Tên bệnh nhân</th>
                    <th>Số điện thoại</th>
                    <th>Bác sĩ</th>
                    <th>Chuyên khoa</th>
                    <th>Địa điểm</th>
                    <th>Ngày</th>
                    <th>Giờ</th>
                    <th>Tổng chi phí</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->id }}</td>
                        <td>{{ $appointment->patient_name }}</td>
                        <td>{{ $appointment->patient_phone }}</td>
                        <td>{{ $appointment->doctor_name }}</td>
                        <td>{{ $appointment->specialty }}</td>
                        <td>{{ $appointment->location_name }}</td>
                        <td>{{ $appointment->date }}</td>
                        <td>{{ $appointment->time_slot }}</td>
                        <td>{{ number_format($appointment->total_cost, 0, ',', '.') }} VNĐ</td>
                        <td>
                            @if($appointment->status == 0) Chưa thanh toán
                            @elseif($appointment->status == 1) Đã thanh toán
                            @elseif($appointment->status == 2) Đã hủy
                            @endif
                        </td>
                        <td>
                            <div class="actions">
                                <!-- Dòng 1: Nút Thanh toán và In phiếu -->
                                <div class="action-line">
                                    <!-- Nút Thanh toán -->
                                    <form id="payment-confirm-form-{{ $appointment->id }}" action="{{ route('appointment.paymentconfirm', ['id' => $appointment->id]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="button" class="btn-icon btn-payment" onclick="confirmPayment({{ $appointment->id }})"></button>
                                    </form>
                                    <!-- Nút In phiếu -->
                                    <button class="btn-icon btn-print" onclick="showAppointmentModal({{ $appointment->id }})"></button>
                                </div>

                                <!-- Dòng 2: Nút Sửa và Hủy -->
                                <div class="action-line">
                                    <!-- Nút Sửa -->
                                    <form action="{{ route('admin.appointment.edit', ['id' => $appointment->id]) }}" method="GET" style="display: inline;">
                                        <button type="submit" class="btn-icon btn-edit"></button>
                                    </form>

                                    <form id="cancel-form-{{ $appointment->id }}" action="{{ route('admin.appointment.cancel', ['id' => $appointment->id]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="button" class="btn-icon btn-delete" onclick="confirmCancel({{ $appointment->id }})"></button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
            <!-- Phân trang -->
            <div class="pagination-container">
            <ul class="pagination">
                <!-- Trang trước -->
                <li class="pagination-item {{ $appointments->onFirstPage() ? 'disabled' : '' }}">
                    <a href="{{ $appointments->previousPageUrl() }}" class="pagination-link">«</a>
                </li>

                <!-- Hiển thị các trang trước dấu ba chấm -->
                @if ($appointments->currentPage() > 3)
                    <li class="pagination-item">
                        <a href="{{ $appointments->url(1) }}" class="pagination-link">1</a>
                    </li>
                    <li class="pagination-item ellipsis">...</li>
                @endif

                <!-- Các trang gần hiện tại -->
                @foreach (range($appointments->currentPage() - 1, $appointments->currentPage() + 1) as $page)
                    @if ($page > 0 && $page <= $appointments->lastPage())
                        <li class="pagination-item {{ $appointments->currentPage() == $page ? 'active' : '' }}">
                            <a href="{{ $appointments->url($page) }}" class="pagination-link">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach

                <!-- Hiển thị các trang sau dấu ba chấm -->
                @if ($appointments->currentPage() < $appointments->lastPage() - 2)
                    <li class="pagination-item ellipsis">...</li>
                    <li class="pagination-item">
                        <a href="{{ $appointments->url($appointments->lastPage()) }}" class="pagination-link">{{ $appointments->lastPage() }}</a>
                    </li>
                @endif

                <!-- Trang sau -->
                <li class="pagination-item {{ $appointments->hasMorePages() ? '' : 'disabled' }}">
                    <a href="{{ $appointments->nextPageUrl() }}" class="pagination-link">»</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Modal quét QR -->
<div id="qrModal" class="modal" style="display: none; position: fixed;">
    <div class="modal-content">
        <span class="close" onclick="closeQrModal()">&times;</span>
        <h2 style="margin-bottom: 20px; font-size: 24px;">Quét mã QR</h2>
        <video id="video" style="width: 70%; height: 70%;" autoplay></video>
        <canvas id="canvas" style="display: none;"></canvas>
        <p>Kết quả quét: <span id="result">Đang quét...</span></p>
    </div>
</div>

<!-- Modal -->
<div id="appointmentModal" class="modal" style="display: none;">
    <div class="modal-content" style="padding: 20px; background-color: #f9f9f9; border-radius: 10px; width: 650px; margin: auto; position: fixed; top: 52%; left: 50%; transform: translate(-50%, -50%); font-family: Arial, sans-serif; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
        <!-- Close Button -->
        <span class="close" onclick="closeAppointmentModal()" style="color: #333; font-size: 24px; font-weight: bold; float: right; cursor: pointer;">&times;</span>

        <!-- Title -->
        <h2 style="text-align: center; color: #0056b3; font-size: 20px; margin-bottom: 15px; font-weight: bold;">PHIẾU ĐĂNG KÝ KHÁM BỆNH</h2>
        <p style="text-align: center; font-size: 14px; color: #333; margin-bottom: 15px;">
            <strong>ID Phiếu đăng ký:</strong> <span id="appointmentId" style="color: #0056b3;">Đang tải...</span>
        </p>

        <!-- Thông tin khách hàng -->
        <div class="section" style="margin-bottom: 15px; padding: 10px; background-color: #fff; border: 1px solid #ddd; border-radius: 8px;">
            <h3 style="color: #333; font-size: 16px; border-bottom: 2px solid #0056b3; padding-bottom: 5px; margin-bottom: 10px;">Thông tin khách hàng</h3>
            <div style="display: flex; flex-wrap: wrap; gap: 30px;">
                <div style="flex: 1; min-width: 250px; text-align: left;">
                    <p><strong>Tên bệnh nhân:</strong> <span id="patientName">Đang tải...</span></p>
                    <p><strong>Số điện thoại:</strong> <span id="phone">Đang tải...</span></p>
                    <p><strong>Email:</strong> <span id="email">Đang tải...</span></p>
                </div>
                <div style="flex: 1; min-width: 150px; text-align: left;">
                    <p><strong>Ngày sinh:</strong> <span id="dob">Đang tải...</span></p>
                    <p><strong>Giới tính:</strong> <span id="gender">Đang tải...</span></p>
                </div>
            </div>
        </div>

        <!-- Thông tin phiếu đăng ký -->
        <div class="section" style="padding: 10px; background-color: #fff; border: 1px solid #ddd; border-radius: 8px;">
            <h3 style="color: #333; font-size: 16px; border-bottom: 2px solid #0056b3; padding-bottom: 5px; margin-bottom: 10px;">Thông tin phiếu đăng ký</h3>
            <div style="display: flex; flex-wrap: wrap; gap: 30px;">
                <div style="flex: 1; min-width: 250px; text-align: left;">
                    <p><strong>Địa điểm:</strong> <span id="location">Đang tải...</span></p>
                    <p><strong>Chuyên khoa:</strong> <span id="specialty">Đang tải...</span></p>
                    <p><strong>Tên bác sĩ:</strong> <span id="doctorName">Đang tải...</span></p>
                </div>
                <div style="flex: 1; min-width: 150px; text-align: left;">
                    <p><strong>Ngày hẹn:</strong> <span id="appointmentDate">Đang tải...</span></p>
                    <p><strong>Giờ hẹn:</strong> <span id="timeSlot">Đang tải...</span></p>
                    <p><strong>Chi phí:</strong> <span id="appointmentCost">Đang tải...</span></p>
                </div>
                <div style="width: 100%; text-align: left;">
                    <p><strong>Lý do khám:</strong> <span id="reason">Đang tải...</span></p>
                    <p><strong>Trạng thái thanh toán:</strong> <span id="status-modal">Đang tải...</span></p>
                </div>
            </div>
        </div>
        <!-- Thông tin ngày và xác thực -->
        <div class="footer" style="background-color: #0056b3; color: #ffffff; text-align: center; padding: 5px 10px; font-size: 11px; position: relative; bottom: 0; width: 100%; box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.1);">
            <p style="margin: 5px 0; font-size:14px"><strong>Ngày in:</strong> <span id="printDate" style="font-weight: normal;">Đang tải...</span></p>
            <p style="margin: 5px 0; font-size:14px"><strong>Xác nhận bởi:</strong> <span style="font-weight: normal;">Hệ thống chăm sóc sức khỏe HealthCare</span></p>
        </div>


        <!-- Print Button -->
        <div style="text-align: center; margin-top: 20px;">
            <button id="printButton" onclick="printDirectlyFromModal()" style="padding: 10px 20px; background-color: #0056b3; color: white; border: none; cursor: pointer; border-radius: 8px; font-size: 14px; font-weight: bold;">
                In phiếu
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.min.js"></script>
<script>
    const video = document.getElementById("video");
    const canvas = document.getElementById("canvas");
    const canvasContext = canvas.getContext("2d");
    const result = document.getElementById("result");
    const qrModal = document.getElementById("qrModal");
    const appointmentModal = document.getElementById("appointmentModal");
    const appointmentIdElement = document.getElementById("appointmentId");

    function openQrModal() {
        const qrModal = document.getElementById('qrModal');
        qrModal.style.display = 'block';

        // Lấy video
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const resultElement = document.getElementById('result');

        // Xóa kết quả quét cũ trước khi quét mới
        resultElement.textContent = 'Đang quét...';

        // Bắt đầu camera
        navigator.mediaDevices
            .getUserMedia({ video: { facingMode: "environment" } })
            .then((stream) => {
                video.srcObject = stream;
                scanQRCode();
            })
            .catch((err) => {
                console.error("Không thể truy cập camera:", err);
                alert("Không thể mở camera. Vui lòng kiểm tra quyền truy cập.");
            });
    }

    function closeQrModal() {
        qrModal.style.display = "none";
        stopCamera();
    }

    function scanQRCode() {
        const interval = setInterval(() => {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvasContext.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Lấy dữ liệu QR
            const imageData = canvasContext.getImageData(0, 0, canvas.width, canvas.height);
            const code = jsQR(imageData.data, imageData.width, imageData.height);

            if (code) {
                clearInterval(interval);
                stopCamera();

                // Hiển thị ID từ mã QR
                const qrId = code.data;
                result.textContent = `${qrId}`;
                closeQrModal();
                showAppointmentModal(qrId);
            }
        }, 300); // Quét mỗi 300ms
    }

    function stopCamera() {
        const stream = video.srcObject;
        if (stream) {
            const tracks = stream.getTracks();
            tracks.forEach((track) => track.stop());
            video.srcObject = null;
        }
    }



// Hàm để hiển thị modal và điền thông tin vào
function showAppointmentModal(id) {
    // Hiển thị modal
    const appointmentModal = document.getElementById('appointmentModal');
    const appointmentIdElement = document.getElementById('appointmentId');
    const patientNameElement = document.getElementById('patientName');
    const appointmentDateElement = document.getElementById('appointmentDate');
    const appointmentCostElement = document.getElementById('appointmentCost');
    const doctorNameElement = document.getElementById('doctorName');
    const specialtyElement = document.getElementById('specialty');
    const locationElement = document.getElementById('location');
    const timeSlotElement = document.getElementById('timeSlot');
    const reasonElement = document.getElementById('reason');
    const statusElement = document.getElementById('status-modal'); // Thêm dòng này để hiển thị trạng thái
    console.log(statusElement); // Phải trả về <p id="status">...</p>
    const phoneElement = document.getElementById('phone');
    const dobElement = document.getElementById('dob');
    const genderElement = document.getElementById('gender');
    const emailElement = document.getElementById('email');
    const printButton = document.getElementById('printButton');
    
    // Hiển thị "Đang tải..." trong modal trước khi lấy dữ liệu
    appointmentIdElement.textContent = "ID: Đang tải...";
    patientNameElement.textContent = "Tên bệnh nhân: Đang tải...";
    appointmentDateElement.textContent = "Ngày hẹn: Đang tải...";
    appointmentCostElement.textContent = "Chi phí: Đang tải...";
    doctorNameElement.textContent = "Tên bác sĩ: Đang tải...";
    specialtyElement.textContent = "Chuyên khoa: Đang tải...";
    locationElement.textContent = "Địa điểm: Đang tải...";
    timeSlotElement.textContent = "Giờ hẹn: Đang tải...";
    reasonElement.textContent = "Lý do khám: Đang tải...";
    statusElement.textContent = "Trạng thái: Đang tải..."; // Đảm bảo rằng status có giá trị "Đang tải..."
    console.log(statusElement.textContent); // Phải hiển thị đúng giá trị
    phoneElement.textContent = "Số điện thoại: Đang tải...";
    dobElement.textContent = "Ngày sinh: Đang tải...";
    genderElement.textContent = "Giới tính: Đang tải...";
    emailElement.textContent = "Email: Đang tải...";

    // Lấy giờ hiện tại theo múi giờ Việt Nam
    const now = new Date();
    const vietnamTime = new Intl.DateTimeFormat('vi-VN', {
        timeZone: 'Asia/Ho_Chi_Minh',
        dateStyle: 'full',
        timeStyle: 'medium'
    }).format(now);
    
    const currentDateElement = document.getElementById('printDate');
    if (currentDateElement) {
        currentDateElement.textContent = `${vietnamTime}`;
    }


    // Mở modal
    appointmentModal.style.display = "block";

    // Gọi API để lấy thông tin phiếu đăng ký từ ID
    fetch(`/quanlyksk/admin/appointments/receipt/${id}`)
        .then((response) => {
            if (!response.ok) {
                throw new Error("Không tìm thấy thông tin phiếu.");
            }
            return response.json(); // Giả sử response trả về JSON
        })
        .then((data) => {
            // Kiểm tra nếu thành công
            console.log(data);
            if (data.success) {
                // Cập nhật thông tin vào modal
                appointmentIdElement.textContent = `${data.data.id || "Không có dữ liệu"}`;
                patientNameElement.textContent = `${data.data.patient_name || "Không có dữ liệu"}`;
                appointmentDateElement.textContent = `${data.data.date || "Không có dữ liệu"}`;
                appointmentCostElement.textContent = data.data.total_cost ? `${Number(data.data.total_cost).toLocaleString('vi-VN')} VNĐ` : "Không có dữ liệu";
                doctorNameElement.textContent = `${data.data.doctor_name || "Không có dữ liệu"}`;
                specialtyElement.textContent = `${data.data.specialty || "Không có dữ liệu"}`;
                locationElement.textContent = `${data.data.location_name || "Không có dữ liệu"}`;
                timeSlotElement.textContent = `${data.data.time_slot || "Không có dữ liệu"}`;
                reasonElement.textContent = `${data.data.reason || "Không có dữ liệu"}`;

                // Hiển thị trạng thái đã xử lý từ API
                console.log(data.data.status); // Kiểm tra giá trị nhận được
                statusElement.textContent = `${data.data.status || "Không có dữ liệu"}`;
                phoneElement.textContent = `${data.data.phone || "Không có dữ liệu"}`;
                dobElement.textContent = `${data.data.dob || "Không có dữ liệu"}`;
                genderElement.textContent = `${data.data.gender || "Không có dữ liệu"}`;
                emailElement.textContent = `${data.data.email || "Không có dữ liệu"}`;
            }
        })
        .catch((err) => {
            console.error("Lỗi khi gọi API:", err);
            alert("Lỗi khi tải thông tin phiếu đăng ký.");
            appointmentModal.style.display = "none";
        });
}


// Hàm đóng modal
function closeAppointmentModal() {
    const appointmentModal = document.getElementById('appointmentModal');
    appointmentModal.style.display = "none";
}

function printDirectlyFromModal() {
    const status = document.getElementById('status-modal').textContent.trim();

    // Kiểm tra trạng thái trước khi in
    if (status === "Chưa thanh toán" || status === "Đã hủy") {
        alert("Không thể in giấy hẹn vì trạng thái là: " + status);
        return; // Dừng hàm nếu trạng thái không hợp lệ
    }

    const modalContent = document.querySelector('#appointmentModal .modal-content').innerHTML;

    // Tạo tài liệu in tạm thời
    const printWindow = window.open('', '_blank', 'width=800,height=600');
    printWindow.document.open();
    printWindow.document.write(`
        <html>
        <head>
            <title>Giấy hẹn</title>
            <style>
                /* Ẩn các thành phần không cần thiết khi in */
                @media print {
                    .close, #printButton {
                        display: none; /* Ẩn nút đóng và nút in */
                    }
                    body {
                        margin: 0;
                        font-family: Arial, sans-serif;
                    }
                }
                /* Định dạng chung */
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                }
            </style>
        </head>
        <body>
            ${modalContent}
        </body>
        </html>
    `);
    printWindow.document.close();

    // Mở hộp thoại in ngay khi nội dung tải xong
    printWindow.onload = function () {
        printWindow.print();
        printWindow.close(); // Đóng cửa sổ sau khi in
    };
}


function resetModalContent() {
    appointmentIdElement.textContent = "ID: Đang tải...";
    patientNameElement.textContent = "Tên bệnh nhân: Đang tải...";
    appointmentDateElement.textContent = "Ngày hẹn: Đang tải...";
    appointmentCostElement.textContent = "Chi phí: Đang tải...";
    doctorNameElement.textContent = "Tên bác sĩ: Đang tải...";
    specialtyElement.textContent = "Chuyên khoa: Đang tải...";
    locationElement.textContent = "Địa điểm: Đang tải...";
    timeSlotElement.textContent = "Giờ hẹn: Đang tải...";
    reasonElement.textContent = "Lý do khám: Đang tải...";
    statusElement.textContent = "Trạng thái: Đang tải...";
    phoneElement.textContent = "Số điện thoại: Đang tải...";
    dobElement.textContent = "Ngày sinh: Đang tải...";
    genderElement.textContent = "Giới tính: Đang tải...";
    emailElement.textContent = "Email: Đang tải...";
}

    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Thành công',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000
        });
    @endif

    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Lỗi',
            text: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 3000
        });
    @endif

    function confirmCancel(id) {
        Swal.fire({
            title: 'Bạn có chắc chắn muốn hủy?',
            text: "Hành động này không thể hoàn tác!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hủy lịch hẹn',
            cancelButtonText: 'Không'
        }).then((result) => {
            if (result.isConfirmed) {
                // Gửi form hủy
                document.getElementById('cancel-form-' + id).submit();
            }
        });
    }

    function confirmPayment(appointmentId) {
        Swal.fire({
            title: 'Xác nhận thanh toán?',
            text: "Bạn có chắc chắn muốn xác nhận thanh toán cho lịch hẹn này?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xác nhận',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                // Gửi form nếu xác nhận
                document.getElementById(`payment-confirm-form-${appointmentId}`).submit();
            }
        });
    }

</script>


@endsection

