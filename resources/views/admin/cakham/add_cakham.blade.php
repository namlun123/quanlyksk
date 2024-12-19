@extends("layouts.admin")
@section("content")
<!-- Bootstrap DatePicker JavaScript -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<div class="container py-2">
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-4">
            @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                <h4 class="text-uppercase text-title-form">THÔNG TIN CA KHÁM</h4>
                <form action="{{ route('admin.save.cakham') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Date -->
                        <div class="form-group col-lg-6">
                            <label class="form-label mb-1 text-2 required">Ngày</label>
                            <input type="date" 
                            class="form-control text-3 h-auto py-2" 
                            name="date" 
                            id="Date" 
                            required="" 
                            onchange="onDateChange()" 
                            min="">
                        </div>

                         <!-- Location -->
                         <div class="form-group col-lg-12">
                            <label class="form-label mb-1 text-2 required">Chi nhánh</label>
                            <select class="form-select form-control h-auto py-2" id="Location" name="location_id" required="" onchange="fetchDoctors(this.value)">
                                <option value="" disabled selected>Vui lòng chọn chi nhánh</option>
                                @foreach ($all_locations as $location)
                                    <option value="{{ $location->location_id }}" {{ old('location_id') == $location->location_id ? 'selected' : '' }}>
                                        {{ $location->location_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Doctor -->
                        <div class="form-group col-lg-12">
                            <label class="form-label mb-1 text-2 required">Bác sĩ</label>
                            <select class="form-select form-control h-auto py-2" id="Doctor" name="doctor_id" required="" onchange="onDoctorChange()">
                                <option value="" disabled selected>Vui lòng chọn bác sĩ</option>
                            </select>
                        </div>

                        <!-- Time Start -->
                        <div class="form-group col-lg-6">
                            <label class="form-label mb-1 text-2 required">Giờ bắt đầu</label>
                            <input type="time" class="form-control text-3 h-auto py-2" name="time_start" id="TimeStart" required="">
                        </div>

                        <!-- Time Finish -->
                        <div class="form-group col-lg-6">
                            <label class="form-label mb-1 text-2 required">Giờ kết thúc</label>
                            <input type="time" class="form-control text-3 h-auto py-2" name="time_finish" id="TimeFinish" required="">
                        </div>

                  <!-- Tổng thời gian -->
                                        
                        <div class="form-group col-lg-6">
                            <label class="form-label mb-1 text-2 required">Tổng thời gian</label>
                            <input type="number" class="form-control text-3 h-auto py-2" name="total_time" id="TotalTime" required min="2" step="1" value="{{ old('total_time') }}">
                        </div>



                        <!-- Extra Cost -->
                        <div class="form-group col-lg-6">
                            <label class="form-label mb-1 text-2">Chi phí thêm</label>
                            <input type="number" class="form-control text-3 h-auto py-2" name="extra_cost" id="ExtraCost" placeholder="Nhập chi phí thêm" min="0" step="1000">
                        </div>

                    </div>

                    <div class="form-group col-lg-12">
                        <button type="submit" name="add_cakham" class="btn btn-info">Thêm mới ca khám</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bảng lịch ca khám -->
        <div class="col-lg-6">
            <div class="mb-4">
                <h4 class="text-uppercase text-title-form" id="scheduleTitle">Lịch Ca Khám</h4>
                <table class="table table-bordered" id="scheduleTable">
                    <!-- Bảng lịch ca khám sẽ được hiển thị ở đây -->
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
    // Kiểm tra tổng thời gian khi form được gửi hoặc khi trường "Tổng thời gian" thay đổi
        function onFormSubmit() {
            const totalTime = document.getElementById('TotalTime').value;

            // Kiểm tra nếu tổng thời gian không phải là số nguyên dương lớn hơn 1
            if (totalTime <= 1 || !Number.isInteger(Number(totalTime))) {
                alert("Tổng thời gian phải là một số nguyên dương lớn hơn 1.");
                return false; // Ngừng gửi form
            }

            return true; // Cho phép gửi form nếu hợp lệ
        }

    // Gọi lại hàm fetchDoctors sau khi trang được tải lại
    $(document).ready(function() {
            var locationId = '{{ old('location_id') }}'; // Lấy giá trị chi nhánh đã chọn trước đó (nếu có)
        if (!locationId) {
            document.getElementById('Doctor').setAttribute('disabled', true); // Vô hiệu hóa dropdown bác sĩ nếu chưa chọn chi nhánh
        } else {
            fetchDoctors(locationId); // Lấy lại danh sách bác sĩ nếu chi nhánh đã được chọn
        }
        var locationId = '{{ old('location_id') }}'; // Giữ giá trị location_id cũ
        if (locationId) {
            fetchDoctors(locationId); // Gọi lại fetchDoctors với location_id cũ
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
    // Lấy ngày hiện tại
    const today = new Date();
    // Tính ngày sau ngày hiện tại 1 ngày
    today.setDate(today.getDate() + 1);
    // Định dạng ngày thành 'YYYY-MM-DD'
    const tomorrow = today.toISOString().split('T')[0];
    // Gán giá trị `min` cho input `date`
    document.getElementById('Date').setAttribute('min', tomorrow);
});
      // Kiểm tra ngày hợp lệ khi thay đổi
      function onDateChange() {
    const today = new Date();
    const selectedDate = new Date(document.getElementById('Date').value);
    
    // Thêm 2 ngày vào ngày hôm nay
    today.setDate(today.getDate() + 1);

    // Kiểm tra nếu ngày được chọn nhỏ hơn ngày tối thiểu (hôm nay + 2 ngày)
    if (selectedDate < today) {
        // Thông báo yêu cầu chọn ngày từ hôm nay cộng thêm 2 ngày
        alert("Bạn hãy chọn sau ngày " + today.toISOString().split('T')[0]);
        document.getElementById('Date').value = ''; // Reset ngày đã chọn
    }}

    //lọc bác sĩ
    function fetchDoctors(locationId) {
    let doctorSelect = document.getElementById('Doctor');
    doctorSelect.innerHTML = '<option value="" disabled selected>Vui lòng chọn bác sĩ</option>'; // Reset options

    // Vô hiệu hóa dropdown bác sĩ nếu không có chi nhánh được chọn
    if (!locationId) {
        doctorSelect.setAttribute('disabled', true);
        return;
    }

    // Kích hoạt dropdown bác sĩ
    doctorSelect.removeAttribute('disabled');

    // Gửi yêu cầu AJAX để lấy danh sách bác sĩ
    fetch('{{ route('admin.get.doctors') }}?location_id=' + locationId)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                data.forEach(function(doctor) {
                    let option = document.createElement('option');
                    option.value = doctor.id;
                    option.text = `${doctor.HoTen} - ${doctor.id}`; // Gộp tên và mã bác sĩ
                    doctorSelect.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Đã có lỗi xảy ra. Vui lòng thử lại!');
        });
}
document.addEventListener('DOMContentLoaded', function() {
    // Hàm kiểm tra thời gian hợp lệ (7:00 AM đến 10:00 PM)
    function validateTime(time) {
        const [hours, minutes] = time.split(':').map(Number);
        if (hours < 7 || (hours === 7 && minutes === 0) || hours >= 22) {
            return false; // Nếu thời gian không hợp lệ (ngoài khoảng từ 7:00 AM đến 10:00 PM)
        }
        return true;
    }

    // Kiểm tra giờ khi người dùng thay đổi
    function onTimeChange(inputId) {
        const timeInput = document.getElementById(inputId);
        const timeValue = timeInput.value;

        if (timeValue && !validateTime(timeValue)) {
            alert("Giờ không hợp lệ. Bạn chỉ có thể chọn giờ từ 7:00 sáng đến 10:00 tối.");
            timeInput.value = ''; // Reset giá trị nếu không hợp lệ
        }
    }

    // Thêm sự kiện cho input giờ bắt đầu và giờ kết thúc
    document.getElementById('TimeStart').addEventListener('change', function() {
        onTimeChange('TimeStart');
    });

    document.getElementById('TimeFinish').addEventListener('change', function() {
        onTimeChange('TimeFinish');
    });
    
    // Gọi lại hàm fetchDoctors sau khi trang được tải lại
    var locationId = '{{ old('location_id') }}'; // Lấy giá trị chi nhánh đã chọn trước đó (nếu có)
    if (!locationId) {
        document.getElementById('Doctor').setAttribute('disabled', true); // Vô hiệu hóa dropdown bác sĩ nếu chưa chọn chi nhánh
    } else {
        fetchDoctors(locationId); // Lấy lại danh sách bác sĩ nếu chi nhánh đã được chọn
    }
});
function validateTotalTime() {
        const input = document.getElementById('TotalTime');
        const error = document.getElementById('TotalTimeError');
        const value = input.value;

        // Kiểm tra nếu không phải số nguyên hoặc <= 0
        if (!/^\d+$/.test(value) || parseInt(value, 10) <= 0) {
            error.style.display = 'Hãy nhập số nguyên lớn hơn 0'; // Hiển thị thông báo lỗi
        } else {
            error.style.display = 'none'; // Ẩn thông báo lỗi
        }
    }

</script>
