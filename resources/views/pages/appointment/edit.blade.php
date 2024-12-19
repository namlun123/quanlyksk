@extends('layout')

@section('content')
<style>
    .appointment-form {
        width: 80%; /* Điều chỉnh độ rộng của form */
        margin: auto;
        margin-top: 20px;
        padding: 20px;
        border: 1px solid #ccc;
        background-color: #f9f9f9;
        border-radius: 8px;
    }

    .appointment-form h2 {
        text-align: center;
        margin-bottom: 15px;
        font-size: 22px;
        font: bold;
    }

    .appointment-form label {
        display: block;
        margin: 10px 0 5px;
        color:rgb(0, 63, 131); /* Màu xanh nổi bật */
        font-size: 15px;
        font-weight: bold;
    }

    .appointment-form input,
    .appointment-form select,
    .appointment-form textarea {
        width: 100%;
        padding: 8px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .appointment-form button {
        width: 100%;
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    .appointment-form button:hover {
        background-color: #45a049;
    }

    /* Flexbox cho Bệnh viện/phòng khám, Chuyên khoa, Bác sĩ (Dọc) */
    .appointment-form .form-group-flex {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-bottom: 20px;
    }

    /* Cấu trúc của các hàng */
    .row {
        display: flex; /* Sử dụng Flexbox cho các cột nằm ngang */
        gap: 20px; /* Khoảng cách giữa các cột */
        margin-bottom: 20px; /* Khoảng cách giữa các hàng */
        flex-wrap: nowrap; /* Đảm bảo không có phần tử nào xuống dòng */
    }

    /* Cột bên trái và bên phải */
    .col-8 {
        flex: 0 0 61%; /* Cột bên trái chiếm 8 phần (2/3 chiều rộng) */
    }

    .col-4 {
        flex: 0 0 34%; /* Cột bên phải chiếm 4 phần (1/3 chiều rộng) */
    }


        /* Ngày khám và Giờ khám hiển thị theo kiểu ngang */
        .appointment-form .time-group {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .appointment-form .time-group .time-item {
            flex: 1;
            padding: 10px;
            text-align: center;
            background-color: #f0f0f0;
            border-radius: 5px;
            cursor: pointer;
            border: 1px solid #ccc;
        }

        .appointment-form .time-group .time-item:hover {
            background-color: #ddd;
        }

        /* Phần ngày và giờ sẽ rộng ra */
        .appointment-form .time-group .time-item.active {
            background-color: #4CAF50;
            color: white;
        }

        /* Điều chỉnh Responsive cho màn hình nhỏ */
        @media (max-width: 768px) {
            .appointment-form {
                width: 90%;
            }

            .appointment-form .time-group {
                flex-direction: column;
            }

            .appointment-form .time-group .time-item {
                width: 100%;
                margin-bottom: 10px;
            }
        }
        .time-table {
        width: 100%;
        text-align: left; /* Đảm bảo các mục canh trái */
    }

    .time-item {
        display: inline-block; /* Hiển thị các mục theo dòng ngang */
        width: auto; /* Chiều rộng tự động */
        min-width: 80px; /* Chiều rộng tối thiểu */
        max-width: 120px; /* Chiều rộng tối đa */
        padding: 5px 8px;
        font-size: 14px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
        text-align: center;
        white-space: nowrap;
        cursor: pointer;
        margin-right: 10px;
        box-sizing: border-box;
    }

    .time-item.pending {
        background-color: #fff3cd;
        color: #856404;
    }

    .time-item.active {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    .error-message {
        color: red;
        text-align: center;
        font-size: 14px;
        margin-top: 10px;
    }
    .error-message {
        color: red;
        text-align: center;
        font-size: 14px;
        margin-top: 10px;
    }

    .item_date, .time-item {
        padding: 10px;
        margin: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        background-color: #f8f9fa;
    }

    /* Ô được chọn */
    .item_date.active, .time-item.active {
        background-color: #00b894;
        color: #fff;
        border: 2px solid #00b894;
    }

    /* Khung giờ bị làm mờ */
    .time-item.booked {
        background-color: #e9ecef;
        color: #6c757d;
        cursor: not-allowed;
        border: 1px solid #ddd;
    }

    .time-item div {
        margin: 3px 0;
    }

    .time-item span {
        color: #007bff;
    }

    .time-item strong {
        color: #333;
    }

    input[type="date"] {
        opacity: 1;            /* Đảm bảo input có thể nhìn thấy */
        position: relative;    /* Đặt lại vị trí của input */
        width: 100%;           /* Đảm bảo chiều rộng của input là 100% hoặc theo ý muốn */
        height: auto;          /* Đặt chiều cao tự động cho input */
        padding: 5px;          /* Thêm khoảng cách bên trong cho input */
    }

    /* Overlay mờ nền */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }

    /* Nội dung modal */
    .modal-content {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        width: 600px;
        max-height: 80%;
        overflow-y: auto;
        position: relative;
    }

    /* Nút đóng modal */
    .modal-close-btn {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 24px;
        cursor: pointer;
        color: #333;
    }

    .modal-close-btn:hover {
        color: red;
    }

    /* Item trong danh sách */
    .specialty-item {
        border: 1px solid #ddd;
        border-radius: 5px;
        margin: 10px 0;
        padding: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .specialty-item:hover {
        background-color: #f9f9f9;
    }

    .select-specialty-btn {
        background-color: #28a745;
        color: #fff;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        border-radius: 3px;
    }

    .select-specialty-btn:hover {
        background-color: #218838;
    }

    #specialization-display {
        flex: 1; /* Chiều ngang tự động co giãn */
        height: 40px; /* Chiều cao đồng nhất */
        padding: 5px 10px; /* Khoảng cách bên trong */
        border: 1px solid #ddd; /* Đường viền */
        border-radius: 5px; /* Bo góc */
        box-sizing: border-box;
    }

    #chooseSpecializationBtn {
        height: 40px; /* Chiều cao bằng ô text */
        width: 150px; /* Chiều ngang cố định */
        border: none;
        background-color: #007bff; /* Màu nền */
        color: white; /* Màu chữ */
        border-radius: 5px; /* Bo góc */
        cursor: pointer;
        text-align: center;
    }

    #chooseSpecializationBtn:hover {
        background-color: #0056b3; /* Màu khi hover */
    }

    /* Dòng kẻ ngăn cách */
    .separator {
        margin: 20px 0; /* Khoảng cách trên và dưới dòng */
        border: 0; /* Loại bỏ đường viền mặc định */
        border-top: 1px solid #ddd; /* Đường viền trên */
        background-color: transparent; /* Không có màu nền */
        height: 1px; /* Chiều cao */
        width: 100%; /* Kéo dài dòng kẻ */
    }


    /* Định dạng chung cho chi tiết phí */
    #cost_details {
        display: none; /* Ẩn mặc định */
        margin-top: 15px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
        font-size: 14px;
        color: #333;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); /* Hiệu ứng đổ bóng nhẹ */
        line-height: 1.6;
    }


    /* Tiêu đề */
    .cost-header {
        font-size: 15px;
        font-weight: bold;
        color:rgb(0, 63, 131); /* Màu xanh nổi bật */
        margin-bottom: 10px;
        border-bottom: 1px solid #ddd; /* Đường viền dưới */
        padding-bottom: 5px;
    }

    /* Các dòng phí */
    .cost-item {
        font-size: 14px;
        margin-bottom: 8px;
        color: #555; /* Màu chữ xám */
    }

    /* Tổng tiền */
    .cost-total {
        font-size: 15px;
        font-weight: bold;
        color: #d9534f; /* Màu đỏ nổi bật */
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #ddd; /* Đường viền trên */
    }

    /* Phong cách cho thẻ h3 */
    h3 {
        font-size: 20px; /* Kích thước chữ của tiêu đề h3 */
        font-weight: bold; /* Làm đậm chữ */
        margin-bottom: 15px; /* Khoảng cách dưới thẻ h3 */
        text-align: left; /* Căn trái tiêu đề h3 */
        color: #333; /* Màu chữ */
    }

    /* Các tiêu đề h3 trong các form */
    h3 + label {
        margin-top: 0; /* Đảm bảo không có khoảng cách thừa giữa h3 và label */
    }
    /* Phong cách chung cho phần chi tiết thời gian khám */
.appointment-details {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
    margin: 0 auto;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.appointment-title {
    text-align: center;
    font-size: 1.5em;
    margin-bottom: 20px;
    color: #333;
}

.appointment-info-row {
    display: flex;
    justify-content: space-between;
}

.appointment-label {
    font-weight: bold;
    font-size: 1em;
    color: #555;
    flex-basis: 40%;
}

.appointment-info {
    flex-basis: 55%;
    margin-top: 10px;
}

.appointment-value {
    font-size: 1.1em;
    color: #333;
}

.required {
    color: red;
}

.edit-btn-container {
    text-align: center;
    margin-top: 15px;
    width: 150px;
}

.edit-time-btn {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 8px 16px; /* Giảm padding để nút ngắn hơn */
    font-size: 1em;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.edit-time-btn:hover {
    background-color: #0056b3;
}

</style>
<div class="appointment-form">
    <h2>SỬA ĐĂNG KÍ KHÁM</h2>

    <form action="{{ route('appointment.update', ['appointment_id' => $appointment->id]) }}" method="POST">
        @csrf
        @method('PUT') <!-- Specifies that the form should use the PUT method for updating -->

        <div class="row">
            <div class="col-8 left-panel">
                <h3>Thông tin đăng kí</h3>

                <!-- Bệnh viện/phòng khám -->
                <label for="location">Bệnh viện Health Center <span style="color: red;">*</span></label>
                <select name="location_id" id="location" required>
                    <option value="">Chọn Bệnh viện/phòng khám</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->location_id }}" {{ $appointment->location_id == $location->location_id ? 'selected' : '' }}>
                            {{ $location->location_name }}
                        </option>
                    @endforeach
                </select>

                <!-- Chuyên khoa -->
                <label for="specialization">Chuyên khoa <span style="color: red;">*</span></label>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <input type="text" id="specialization-display" placeholder="Hãy chọn chuyên khoa" readonly
                        value="{{ $appointment->specialty_id ? $specialties->firstWhere('specialty_id', $appointment->specialty_id)->specialty : '' }}">
                    <button type="button" id="chooseSpecializationBtn">Chọn chuyên khoa</button>
                </div>
                <input type="hidden" id="specialization" name="specialization_id" value="{{ $appointment->specialty_id }}">

                <!-- Chọn bác sĩ -->
                <label for="doctor">Bác sĩ <span style="color: red;">*</span></label>
                <select name="doctor_id" id="doctor" required>
                    <option value="">Chọn Bác sĩ</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ $appointment->doctor_id == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->HoTen }} - {{ $doctor->ChucVu }}
                        </option>
                    @endforeach
                </select>

                <!-- Lý do khám -->
                <label for="reason">Lý do khám</label>
                <textarea name="reason" id="reason" rows="4">{{ $appointment->reason }}</textarea>
            </div>

            <div class="col-4 right-panel">
                <h3>Thông tin khách hàng</h3>

                <!-- Họ và tên -->
                <label for="name">Họ và tên</label>
                <input type="text" name="name" id="name" value="{{ $patientInfo->HoTen }}" disabled>

                <!-- Số điện thoại -->
                <label for="phone">Số điện thoại</label>
                <input type="tel" name="phone" id="phone" value="{{ $patientInfo->sdt }}" disabled>

                <!-- Ngày tháng năm sinh -->
                <label for="dob">Ngày tháng năm sinh</label>
                <input type="date" name="dob" id="dob" value="{{ $patientInfo->NgaySinh }}" disabled>

                <!-- Email -->
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ $user->email }}" disabled>
            </div>
        </div>

        <div class="row">
            <div class="col-8 left-panel">
                <!-- Phần hiển thị ngay ban đầu, ẩn sau khi ấn button -->
                <div id="appointment_details" class="appointment-details">
                    <div class="appointment-info-row">
                        <label for="specialization" class="appointment-label">Thời gian khám đã đặt <span class="required">*</span></label>
                        <div id="current_date_slot" class="appointment-info">
                            <p id="current_date_time" class="appointment-value">
                                {{ $appointment->date }}
                            </p>
                        </div>
                    </div>

                    <div class="appointment-info-row">
                        <label for="selected_time_slot" class="appointment-label">Thời gian khám đã chọn</label>
                        <div id="current_time_display" class="appointment-info">
                            <p id="current_time_slot" class="appointment-value">
                                {{ $appointment->time_slot }}
                            </p>
                        </div>
                    </div>

                    <div class="appointment-info-row">
                        <label for="selected_total_cost" class="appointment-label">Tổng phí của đơn đăng ký</label>
                        <div id="current_total_cost_display" class="appointment-info">
                            <p id="current_total_cost" class="appointment-value">
                                {{ $appointment->total_cost }}
                            </p>
                        </div>
                </div>
                <div class="edit-btn-container">
                    <button type="button" id="edit_time_btn" class="edit-time-btn">Sửa thời gian</button>
                </div>
                </div>
                <!-- Phần ẩn ban đầu, hiện sau khi ấn button -->
                <div id="edit_time_section" style="display: none;">
                    <div class="col-8 left-panel">
                        <label for="specialization">Thời gian khám <span style="color: red;">*</span></label>

                        <!-- Chọn ngày -->
                        <label for="date_picker">Ngày khám</label>
                        <div id="date_picker" style="display: flex; gap: 10px;"></div>

                        <!-- Trường ẩn để chứa giá trị ngày -->
                        <input type="hidden" name="date" id="selected_date">

                        <label for="date_picker">Giờ khám</label>
                        <!-- Time Slots -->
                        <div id="time_table" class="flex list_date" style="margin-top: 15px;">
                            <!-- Time slots will be populated here by JavaScript -->
                        </div>
                        <input type="hidden" name="time_slot" id="selected_time_slot">
                    </div>
                    <div class="col-4 right-panel">
                        <hr class="separator">
                        <div id="cost_details"></div>
                        <input type="hidden" name="total_cost" id="total_cost" value="{{ $appointment->total_cost }}">
                    </div>
                </div>
            </div>
        </div>
        <!-- Nút submit nằm trong form -->
        <button type="submit">Cập nhật lịch</button>
    </form>
</div>



<!-- Modal -->
<div id="specializationModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <span class="modal-close-btn" id="modalCloseBtn">&times;</span>
            <h3>Danh sách chuyên khoa</h3>
                <input type="text" id="searchSpecialization" placeholder="Tìm kiếm chuyên khoa...">

                <div id="specializationList">
                <!-- Chuyên khoa sẽ được lặp từ server -->
                    @foreach($specialties as $specialty)
                        <div class="specialty-item" data-id="{{ $specialty->specialty_id }}">
                            <h4>{{ $specialty->specialty }}</h4>
                            <p>{{ $specialty->mota }}</p>
                            <button class="select-specialty-btn">Chọn</button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
    renderDays(); // Gọi hàm render ngày khi DOM đã sẵn sàng
    });
    document.addEventListener('DOMContentLoaded', function() {
    const editTimeBtn = document.getElementById('edit_time_btn');
    const editTimeSection = document.getElementById('edit_time_section');
    const appointmentDetails = document.getElementById('appointment_details');
    const doctorPicker = document.getElementById('doctor'); // Dropdown chọn bác sĩ

    // Các phần tử cần ẩn khi nhấn nút "Sửa thời gian"
    const currentDateSlot = document.getElementById('current_date_slot');  // Phần hiển thị ngày
    const currentTimeSlot = document.getElementById('current_time_slot');  // Phần hiển thị thời gian
    const currentDateLabel = document.querySelector('label[for="selected_time_slot"]');  // Label "Ngày khám đã đặt"
    const currentTimeLabel = document.querySelector('label[for="selected_time_slot"]');  // Label "Thời gian khám đã chọn"
    const timeDisplay = document.getElementById('current_time_display');  // Phần hiển thị thời gian đã chọn
    
    const datePicker = document.getElementById('date_picker');
    const timeTable = document.getElementById('time_table');
    const selectedDate = document.getElementById('selected_date');
    const selectedTimeSlot = document.getElementById('selected_time_slot');

    // Khi nhấn vào nút "Sửa thời gian"
    editTimeBtn.addEventListener('click', function() {
        // Ẩn các phần đã đặt

        appointmentDetails.style.display = 'none'; 

        // Hiển thị phần chỉnh sửa
        editTimeSection.style.display = 'block'; 
    });

    // Khi thay đổi bác sĩ từ dropdown
    doctorPicker.addEventListener('change', function() {
        // Ẩn các phần đã đặt

        appointmentDetails.style.display = 'none'; 

        // Hiển thị phần chỉnh sửa
        editTimeSection.style.display = 'block'; 
    });


    const totalCostElement = document.getElementById('current_total_cost');
    
    // Giả sử `total_cost` là giá trị số từ backend
    const totalCost = {{ $appointment->total_cost }};
    
    // Định dạng tiền tệ (ở đây dùng VND)
    const formattedCost = new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
    }).format(totalCost);
    
    // Cập nhật giá trị đã định dạng vào phần tử HTML
    totalCostElement.textContent = formattedCost;

    // Khi chọn ngày, cập nhật giá trị vào trường ẩn
    datePicker.addEventListener('change', function(e) {
        selectedDate.value = e.target.value;
    });
});







    document.addEventListener("DOMContentLoaded", function () {
    const openBtn = document.getElementById("chooseSpecializationBtn");
    const closeBtn = document.getElementById("modalCloseBtn");
    const modal = document.getElementById("specializationModal");
    const searchInput = document.getElementById("searchSpecialization");
    const specializationList = document.getElementById("specializationList");
    const specializationInput = document.getElementById("specialization");

    // Mở modal
    openBtn.addEventListener("click", function () {
        modal.style.display = "flex";
    });

    // Đóng modal
    closeBtn.addEventListener("click", function () {
        modal.style.display = "none";
    });

    // Ẩn modal khi click ra ngoài
    window.addEventListener("click", function (e) {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });

    // Tìm kiếm chuyên khoa
    searchInput.addEventListener("keyup", function () {
        const keyword = searchInput.value.toLowerCase();
        const items = specializationList.querySelectorAll(".specialty-item");
        items.forEach(item => {
            const name = item.querySelector("h4").innerText.toLowerCase();
            item.style.display = name.includes(keyword) ? "flex" : "none";
        });
    });

    // Chọn chuyên khoa
    specializationList.addEventListener("click", function (e) {
        if (e.target.classList.contains("select-specialty-btn")) {
            const item = e.target.closest(".specialty-item");
            const specialtyName = item.querySelector("h4").innerText;
            const specialtyId = item.getAttribute("data-id");

            // Điền ID vào input ẩn và tên vào textbox
            specializationInput.value = specialtyId;
            specializationInput.setAttribute("data-name", specialtyName); // Optional: lưu tên để debug/log
            document.getElementById("specialization-display").value = specialtyName;

            // Gọi hàm cập nhật bác sĩ
            updateDoctors();

            // Đóng modal
            modal.style.display = "none";
        }
    });
});





    // Khi người dùng chọn một khung giờ
    function selectTimeSlot(slot) {
    document.getElementById('time_slot').value = slot.id;  // Cập nhật ID khung giờ vào form
    document.getElementById('total_cost').value = slot.total_cost;  // Cập nhật total_cost
}

    function bindTimeSlotClickEvents() {
        document.querySelectorAll('.time-item').forEach(slot => {
            slot.addEventListener('click', function () {
                this.classList.toggle('active'); // Chọn hoặc bỏ chọn giờ
                console.log(`Khung giờ được chọn: ${this.textContent}`);
            });
        });
    }

    // Hàm định dạng tiền tệ
    function formatCurrency(amount) {
        return amount.toLocaleString('vi-VN') + ' VND';
    }

    function getNextThreeDays() {
        const today = new Date();
        const days = [];

        // Đảm bảo tính toán ngày theo UTC (không bị ảnh hưởng bởi múi giờ)
        const utcToday = Date.UTC(today.getUTCFullYear(), today.getUTCMonth(), today.getUTCDate());

        // Lặp qua 3 ngày tiếp theo
        for (let i = 0; i < 5; i++) {
            let date = new Date(utcToday);  // Tạo đối tượng ngày theo UTC
            date.setUTCDate(today.getUTCDate() + i);  // Cộng thêm i ngày vào ngày hôm nay

            // Lấy ngày theo định dạng YYYY-MM-DD
            let formattedDate = date.toISOString().split('T')[0];

            // Hiển thị ngày theo định dạng DD/MM
            let displayDate = `${date.getUTCDate()}/${date.getUTCMonth() + 1}`;

            // Lấy tên ngày trong tuần
            let dayOfWeek = getDayOfWeek(date.getUTCDay());

            // Đẩy thông tin vào mảng
            days.push({
                date: formattedDate,
                display: displayDate,
                dayOfWeek: dayOfWeek
            });
        }

        // Kiểm tra kết quả của từng ngày
        days.forEach(day => {
            console.log(`Date: ${day.date}, Display: ${day.display}, Day of Week: ${day.dayOfWeek}`);
        });

        return days;
    }

    // Hàm lấy tên thứ trong tuần
    function getDayOfWeek(dayIndex) {
        const days = ["Chủ nhật", "Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7"];
        return days[dayIndex];
    }

    function renderDays() {
        let datePicker = document.getElementById('date_picker');
        if (!datePicker) return;

        datePicker.innerHTML = ''; // Xóa nội dung cũ

        let days = getNextThreeDays();
        days.forEach((day, index) => {
            let dayDiv = document.createElement('div');
            dayDiv.classList.add('item_date');
            dayDiv.setAttribute('data-id', day.date); // Lưu ngày đúng vào data-id
            dayDiv.innerHTML = `<strong>${day.display}</strong><br>${day.dayOfWeek}`;

            //if (index === 0) dayDiv.classList.add('active'); // Chọn mặc định

            dayDiv.addEventListener('click', function () {
                document.querySelectorAll('.item_date').forEach(i => i.classList.remove('active'));
                this.classList.add('active');

                let selectedDate = this.getAttribute('data-id'); // Lấy ngày từ data-id
                document.getElementById('selected_date').value = selectedDate; // Cập nhật giá trị ngày vào trường ẩn
                resetCostDetails();
                updateTimeSlots(selectedDate); // Gọi hàm với ngày được chọn
            });

            datePicker.appendChild(dayDiv);
        });

        // Ô "Ngày khác" với input date
        let otherDayDiv = document.createElement('div');
        otherDayDiv.classList.add('item_date');
        otherDayDiv.innerHTML = `
            <span>Ngày khác</span>
            <input type="date" id="custom_date" style="display: none;">
        `;

        // Lắng nghe sự kiện click vào "Ngày khác"
        otherDayDiv.addEventListener('click', function () {
            let customDateInput = document.getElementById('custom_date');
            customDateInput.style.display = 'block'; // Hiển thị lịch chọn ngày
            customDateInput.focus(); // Focus vào input để dễ dàng chọn ngày

            // Khi người dùng chọn ngày
            customDateInput.addEventListener('change', function () {
                let customDate = this.value; // Lấy ngày chọn từ input
                if (customDate) {
                    document.querySelectorAll('.item_date').forEach(i => i.classList.remove('active'));
                    document.getElementById('selected_date').value = customDate; // Cập nhật giá trị vào trường ẩn
                    resetCostDetails();
                    updateTimeSlots(customDate); // Gọi hàm truy vấn khung giờ với ngày chọn
                }
            });
        });

        datePicker.appendChild(otherDayDiv);
    }

    // Reset tổng tiền
    function resetCostDetails() {
        document.getElementById('cost_details').innerHTML = '';
    }

    function updateTimeSlots(selectedDate) {
        let locationId = document.getElementById('location').value;
        let doctorId = document.getElementById('doctor').value;

        console.log("Ngày chọn: ", selectedDate); // Debug
        if (locationId && doctorId && selectedDate) {
            fetch(`/quanlyksk/get-timeslots/${locationId}/${doctorId}/${selectedDate}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Không tìm thấy lịch khám hợp lệ.'); // Nếu không có dữ liệu hợp lệ
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        displayError(data.error); // Hiển thị lỗi từ server
                    } else {
                        renderTimeSlots(data); // Xử lý hiển thị khung giờ
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi lấy thời gian khám:', error);
                    displayError('Không có lịch khám vào ngày quý khách chọn. Vui lòng chọn ngày khác!');
                });
        }
    }

    // Hiển thị khung giờ và thêm logic chọn 1 khung giờ duy nhất
    function renderTimeSlots(slots) {
        let timeTable = document.getElementById('time_table');
        timeTable.innerHTML = ''; // Xóa khung giờ cũ

        slots.forEach(slot => {
            let timeSlotItem = document.createElement('div');
            timeSlotItem.classList.add('time-item');
            timeSlotItem.textContent = `${slot.timeStart} - ${slot.timeFinish}`;

            // Làm mờ nếu khung giờ đã được đặt
            if (slot.status === 'booked') {
                timeSlotItem.classList.add('booked');
                timeSlotItem.title = 'Đã được đặt';
            } else {
                timeSlotItem.addEventListener('click', function () {
                    // Bỏ chọn tất cả các khung giờ
                    document.querySelectorAll('.time-item').forEach(i => i.classList.remove('active'));
                    this.classList.add('active'); // Đánh dấu khung giờ được chọn

                    // Cập nhật giá trị time_slot vào form ẩn
                    document.getElementById('selected_time_slot').value = `${slot.timeStart} - ${slot.timeFinish}`;

                    console.log(selected_time_slot);

                    // Hiển thị phí khi chọn giờ
                    showCostDetails(slot);
                });
            }

            timeTable.appendChild(timeSlotItem);
        });
    }

// Hiển thị phí và tổng tiền với định dạng tiền tệ
function showCostDetails(slot) {
    let costDetails = document.getElementById('cost_details');
    
    // Kiểm tra nếu có dữ liệu trong slot (ví dụ: total_cost)
    if (slot.phi_co_ban || slot.extra_cost || slot.total_cost) {
        // Cập nhật nội dung chi tiết phí
        costDetails.innerHTML = `
            <div class="cost-header">Chi tiết phí</div>
            <div class="cost-item">Phí khám cơ bản: <strong>${formatCurrency(slot.phi_co_ban)}</strong></div>
            <div class="cost-item">Phí khám ngoài giờ: <strong>${formatCurrency(slot.extra_cost)}</strong></div>
            <div class="cost-total">Tổng tiền: <strong>${formatCurrency(slot.total_cost)}</strong></div>
            <div class="mt2" style="margin-top: 7px;">
                <strong>Lưu ý:</strong> Chi phí trên chỉ là phí thăm khám với bác sĩ (Không bao gồm các chi phí phát sinh khi thăm khám như: xét nghiệm, chữa trị,...)
            </div>
        `;
        
        // Hiển thị phần chi tiết phí
        costDetails.style.display = 'block';
    } else {
        // Ẩn phần chi tiết phí nếu không có dữ liệu
        costDetails.style.display = 'none';
    }

    // Thêm tổng phí vào trường hidden
    document.getElementById('total_cost').value = slot.total_cost;  // Cập nhật giá trị của total_cost trong form
}


    function displayError(message) {
        let timeTable = document.getElementById('time_table');
        timeTable.innerHTML = `<div class="error-message">${message}</div>`;
    }

function updateDoctors(resetDoctor = false) {
    let locationId = document.getElementById('location').value;
    let specializationId = document.getElementById('specialization').value;
    const doctorSelect = document.getElementById('doctor');

    // Lưu lựa chọn hiện tại nếu không reset
    const currentDoctorId = resetDoctor ? '' : doctorSelect.value;

    if (locationId && specializationId) {
        fetch(`/quanlyksk/get-doctors/${locationId}/${specializationId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                doctorSelect.innerHTML = '<option value="">Chọn Bác sĩ</option>'; // Reset dropdown

                data.forEach(doctor => {
                    let option = document.createElement('option');
                    option.value = doctor.id;
                    option.textContent = doctor.HoTen + ' - ' + doctor.ChucVu;

                    // Giữ lại lựa chọn hiện tại nếu không reset
                    if (doctor.id == currentDoctorId) {
                        option.selected = true; // Đặt option được chọn
                    }

                    doctorSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Có lỗi xảy ra khi tải bác sĩ:', error);
            });
    } else {
        console.log('Vui lòng chọn Bệnh viện và Chuyên khoa');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('Trang đã tải xong');
    updateDoctors(); // Chạy khi trang tải nhưng không reset lựa chọn bác sĩ

    document.getElementById('location').addEventListener('change', function() {
        console.log('Địa điểm đã thay đổi, reset bác sĩ');
        updateDoctors(true); // Reset bác sĩ khi thay đổi địa điểm
    });

    document.getElementById('specialization').addEventListener('change', function() {
        console.log('Chuyên khoa đã thay đổi, reset bác sĩ');
        updateDoctors(true); // Reset bác sĩ khi thay đổi chuyên khoa
    });
});


    console.log('Mã JavaScript đã được tải');
</script>


@endsection
