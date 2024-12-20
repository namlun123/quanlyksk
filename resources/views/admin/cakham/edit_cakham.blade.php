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
                <h4 class="text-uppercase text-title-form">SỬA THÔNG TIN CA KHÁM</h4>
                <form action="{{ route('admin.update.cakham', $cakham->cakham_id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
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
                            min="{{ \Carbon\Carbon::tomorrow()->toDateString() }}"
                            value="{{ old('date', $cakham->date) }}">
                        </div>

                         <!-- Location -->
                         <div class="form-group col-lg-12">
                            <label class="form-label mb-1 text-2 required">Chi nhánh</label>
                            <select class="form-select form-control h-auto py-2" id="Location" name="location_id" required="" onchange="fetchDoctors(this.value)">
                                <option value="" disabled selected>Vui lòng chọn chi nhánh</option>
                                @foreach ($all_locations as $location)
                                    <option value="{{ $location->location_id }}" {{ old('location_id', $cakham->location_id) == $location->location_id ? 'selected' : '' }}>
                                        {{ $location->location_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Doctor -->
                        <div class="form-group col-lg-12">
                            <label class="form-label mb-1 text-2 required">Bác sĩ</label>
                            <select class="form-select form-control h-auto py-2" id="Doctor" name="doctor_id" required="">
                                <option value="" disabled selected>Vui lòng chọn bác sĩ</option>
                                @foreach ($all_doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id', $cakham->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                        {{ $doctor->HoTen }} - {{ $doctor->id }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <!-- Time Start -->
                        <div class="form-group col-lg-6">
                            <label class="form-label mb-1 text-2 required">Giờ bắt đầu</label>
                            <input type="time" class="form-control text-3 h-auto py-2" name="time_start" id="TimeStart" required="" value="{{ old('time_start', $cakham->time_start) }}">
                        </div>

                        <!-- Time Finish -->
                        <div class="form-group col-lg-6">
                            <label class="form-label mb-1 text-2 required">Giờ kết thúc</label>
                            <input type="time" class="form-control text-3 h-auto py-2" name="time_finish" id="TimeFinish" required="" value="{{ old('time_finish', $cakham->time_finish) }}">
                        </div>

                        <!-- Total Time -->
                        <div class="form-group col-lg-6">
                            <label class="form-label mb-1 text-2 required">Tổng thời gian</label>
                            <input type="text" class="form-control text-3 h-auto py-2" name="total_time" id="TotalTime" value="{{ old('total_time', $cakham->total_time) }}">
                        </div>

                        <!-- Extra Cost -->
                        <div class="form-group col-lg-6">
                            <label class="form-label mb-1 text-2">Chi phí thêm</label>
                            <input type="number" class="form-control text-3 h-auto py-2" name="extra_cost" id="ExtraCost" placeholder="Nhập chi phí thêm" min="0" step="1000" value="{{ old('extra_cost', $cakham->extra_cost) }}">
                        </div>

                    </div>

                    <div class="form-group col-lg-12">
                        <button type="submit" class="btn btn-info">Cập nhật ca khám</button>
                    </div>
                </form>
            </div>
        </div>

@endsection

<script>
    // Gọi lại hàm fetchDoctors sau khi trang được tải lại
    $(document).ready(function() {
        var locationId = '{{ old('location_id', $cakham->location_id) }}'; // Lấy giá trị chi nhánh đã chọn trước đó (nếu có)
        if (locationId) {
            fetchDoctors(locationId); // Gọi lại fetchDoctors với location_id đã chọn
        }

        // Giữ lại giá trị bác sĩ đã chọn trước đó
        var doctorId = '{{ old('doctor_id', $cakham->doctor_id) }}';
        if (doctorId) {
            $("#Doctor").val(doctorId); // Chọn lại bác sĩ đã chọn
        }
    });

    // Hàm lọc bác sĩ
    function fetchDoctors(locationId) {
        let doctorSelect = document.getElementById('Doctor');
        doctorSelect.innerHTML = '<option value="" disabled selected>Vui lòng chọn bác sĩ</option>'; // Reset options

        if (!locationId) {
            doctorSelect.setAttribute('disabled', true);
            return;
        }

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
                        option.text = `${doctor.HoTen} - ${doctor.id}`;
                        doctorSelect.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Đã có lỗi xảy ra. Vui lòng thử lại!');
            });
    }

    // Kiểm tra ngày hợp lệ khi thay đổi
    function onDateChange() {
        const today = new Date();
        const selectedDate = new Date(document.getElementById('Date').value);
        today.setDate(today.getDate() + 1); // Ngày hôm sau

        if (selectedDate < today) {
            alert("Bạn hãy chọn từ ngày " + today.toISOString().split('T')[0]);
            document.getElementById('Date').value = ''; // Reset ngày đã chọn
        }
    }
</script>
