@extends('layouts.admin')
@section('content')
<div style="min-height:48vh">
    <h3 class="text-center mt-3">DANH SÁCH CA KHÁM</h3>
    <div class="container">
        <div class="row w3-res-tb">
            <form action="" method="get" class="">
                <div class="row">
                <div class="col-sm-6 m-b-xs">
                        <select class="input-sm form-control w-sm inline v-middle" name="location_id">
                            <option value="0" selected="selected">Chọn địa điểm</option>
                            @php
                            $all_locations = DB::table('locations')->get();
                            @endphp
                            @foreach ($all_locations as $location)
                            <option value="{{ $location->location_id }}" {{ request()->location_id == $location->location_id ? 'selected' : '' }}>
                                {{ $location->location_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6 m-b-xs">
                    <select class="input-sm form-control w-sm inline v-middle" id="Doctor" name="doctor_id" disabled>
                        <option value="0" selected="selected">Chọn bác sĩ</option>
                            @php
                            $all_doctors = DB::table('doctors')->get();
                            @endphp
                            @foreach($all_doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ request()->doctor_id == $doctor->id ? 'selected' : '' }}>
                                {{ $doctor-> HoTen }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="row mt-3">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <input type="search" name="keywords" class="form-control" placeholder="Tìm kiếm theo từ khóa">
                            <div class="input-group-append">
                                <button type="submit" id="apply_button" class="btn btn-primary">Lọc</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            @php
            $all_cakham = DB::table('cakham')
                ->join('doctors', 'cakham.doctor_id', '=', 'doctors.id')
                ->select('cakham.*', 'doctors.HoTen as doctor_name');

            // Áp dụng filter chi nhánh
            if (request()->has('location_id') && request()->location_id != 0) {
                $all_cakham->where('cakham.location_id', request()->location_id); // Thêm 'cakham.' trước cột location_id
            }

            // Áp dụng filter bác sĩ
            if (request()->has('doctor_id') && request()->doctor_id != 0) {
                $all_cakham->where('cakham.doctor_id', request()->doctor_id); // Thêm 'cakham.' trước cột doctor_id
            }

            // Áp dụng tìm kiếm theo từ khóa
            if (request()->has('keywords') && !empty(request()->keywords)) {
                $all_cakham->where(function ($query) {
                    $keywords = request()->keywords;
                    $query->where('cakham.cakham_id', 'like', "%$keywords%") // Thêm 'cakham.' trước cột cakham_id
                        ->orWhere('cakham.date', 'like', "%$keywords%")   // Thêm 'cakham.' trước cột date
                        ->orWhere('cakham.time_start', 'like', "%$keywords%") // Thêm 'cakham.' trước cột time_start
                        ->orWhere('cakham.time_finish', 'like', "%$keywords%") // Thêm 'cakham.' trước cột time_finish
                        ->orWhere('doctors.HoTen', 'like', "%$keywords%"); // Tìm kiếm trong bảng doctors
                });
            }

            // Paginate kết quả
            $all_cakham = $all_cakham->paginate(10);
            @endphp


        </div>

        <table class="table table-hover table-bordered align-middle">
            <thead>
                <tr class="text-center table-primary">
                    <th>Mã Ca Khám</th>
                    <th>Ngày</th>
                    <th>Giờ bắt đầu</th>
                    <th>Giờ kết thúc</th>
                    <th>Tổng thời gian</th>
                    <th>Chi phí phụ</th>
                    <th>Bác sĩ</th>
                    <th>Địa điểm</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($all_cakham as $cakham)
            <tr class="text-center">
                <td>{{ $cakham->cakham_id }}</td>
                <td>{{ $cakham->date }}</td>
                <td>{{ $cakham->time_start }}</td>
                <td>{{ $cakham->time_finish }}</td>
                <td>{{ $cakham->total_time }}</td>
                <td>{{ number_format($cakham->extra_cost, 0, ',', '.') }} VNĐ</td>
                <td>
                    @php
                    $doctor = DB::table('doctors')->where('id', $cakham->doctor_id)->first();
                    echo $doctor ? $doctor->HoTen : 'N/A';
                    @endphp
                </td>
                <td>
                    @php
                    $location = DB::table('locations')->where('location_id', $cakham->location_id)->first();
                    echo $location ? $location->location_name : 'N/A';
                    @endphp
                </td>
                <td>
                    @php
                    $currentDate = now()->format('Y-m-d');
                    $isPast = $cakham->date < $currentDate;
                    @endphp
                    @if (!$isPast) <!-- Hiển thị nút sửa chỉ khi ca khám chưa qua -->
                        <a href="{{ route('admin.edit.cakham', ['id' => $cakham->cakham_id]) }}" class="active styling-edit">
                            <i class="fa fa-pencil-square-o text-success text-active"></i>
                        </a>
                    @endif
                    <a onclick="return confirm('Bạn có muốn xóa không?')" href="{{ route('admin.delete.cakham', ['id' => $cakham->cakham_id]) }}" class="active styling-edit">
                        <i class="fa fa-times text-danger text"></i>
                    </a>
                </td>
            </tr>
        @endforeach


            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $all_cakham->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
<script>
   document.addEventListener('DOMContentLoaded', function() {
    // Lấy các dropdown
    const locationDropdown = document.querySelector('select[name="location_id"]');
    const doctorDropdown = document.getElementById('Doctor');

    // Khi thay đổi chi nhánh
    locationDropdown.addEventListener('change', function() {
        const locationId = this.value;

        // Nếu chưa chọn chi nhánh, disable dropdown bác sĩ
        if (!locationId || locationId == 0) {
            doctorDropdown.innerHTML = '<option value="0" selected="selected">Chọn bác sĩ</option>';
            doctorDropdown.setAttribute('disabled', true);
            return;
        }

        // Nếu đã chọn chi nhánh, bật dropdown bác sĩ
        doctorDropdown.removeAttribute('disabled');
        doctorDropdown.innerHTML = '<option value="0" selected="selected">Đang tải...</option>';

        // Gửi yêu cầu AJAX
        fetch(`{{ route('admin.get.doctors') }}?location_id=${locationId}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    // Điền danh sách bác sĩ
                    doctorDropdown.innerHTML = '<option value="0" selected="selected">Chọn bác sĩ</option>';
                    data.forEach(doctor => {
                        const option = document.createElement('option');
                        option.value = doctor.id;
                        option.textContent = `${doctor.HoTen} - Mã bác sĩ: ${doctor.id}` ;
                        doctorDropdown.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Đã có lỗi xảy ra. Vui lòng thử lại!');
            });
    });
});


</script>
