@extends('layouts.admin')
@section('content')
<div class="container py-2">
    <div class="mb-4">
        <div class="">
            <div class="row place-userInfor">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form Chỉnh Sửa Bác Sĩ -->
                <form action="{{ route('admin.update.doctor', ['id' => $doctor->id]) }}" method="post">
                    @csrf
                    <div class="container">
                        <div class="text-title-form text-center">CẬP NHẬT BÁC SĨ</div>

                        <!-- Tên Bác Sĩ -->
                        <div class="form-group">
                            <label for="HoTen">Tên Bác Sĩ</label>
                            <input type="text" id="HoTen" name="HoTen" value="{{ $doctor->HoTen }}" class="form-control" placeholder="Nhập tên bác sĩ" required>
                        </div>

                        <!-- Chức Vụ -->
                        <div class="form-group">
                            <label for="ChucVu">Chức Vụ</label>
                            <input type="text" id="ChucVu" name="ChucVu" value="{{ $doctor->ChucVu }}" class="form-control" placeholder="Nhập chức vụ bác sĩ" required>
                        </div>

                        <!-- Lương Cơ Bản -->
                         <!-- Lương Cơ Bản -->
<div class="form-group">
    <label for="PhiCoBan">Lương Cơ Bản</label>
    <input 
        type="number" 
        id="PhiCoBan" 
        name="PhiCoBan" 
        class="form-control" 
        placeholder="Nhập lương cơ bản" 
        min="1" 
        required>
</div>




                        <!-- Chuyên Khoa -->
                        
                        <div class="form-group">
    <label for="specialty_id">Chuyên Khoa</label>
    <select name="specialty_id" id="specialty_id" class="form-control">
        @foreach($specialties as $specialty)
            <option value="{{ $specialty->specialty_id }}" 
                {{ $doctor->specialty_id == $specialty->specialty_id ? 'selected' : '' }}>
                {{ $specialty->specialty }}
            </option>
        @endforeach
    </select>
</div>


                        <!-- Địa điểm -->
                        <div class="form-group">
                            <label for="location_id">Địa Điểm</label>
                            <select name="location_id" id="location_id" class="form-control">
                                @foreach($locations as $location)
                                    <option value="{{ $location->location_id }}" {{ $doctor->location_id == $location->location_id ? 'selected' : '' }}>
                                        {{ $location->location_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nút submit -->
                        <div class="btn-container">
                            <button type="submit" class="btn btn-info">Cập nhật bác sĩ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
