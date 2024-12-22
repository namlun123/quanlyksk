@extends('layout')
@section('content')

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background-color: #f8f9fa;
    }

    .doctor-list {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 20px;
    }

    .doctor-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 12px;
        width: calc(25% - 20px); /* 4 bác sĩ mỗi hàng */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.2s ease-in-out;
    }

    .doctor-card:hover {
        transform: scale(1.03);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .doctor-card img {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .doctor-info {
        padding: 15px;
        text-align: left;
    }

    .doctor-info h5 {
        margin: 0 0 5px;
        font-size: 18px;
        color: #007bff;
    }

    .doctor-info p {
        margin: 5px 0;
        font-size: 14px;
        color: #555;
    }

    .doctor-actions {
        text-align: center;
        margin-top: 10px;
    }

    .doctor-actions a {
        display: inline-block;
        padding: 10px 15px;
        font-size: 14px;
        color: #fff;
        background-color: #007bff;
        border-radius: 6px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .doctor-actions a:hover {
        background-color: #0056b3;
    }

    .filter-bar {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        align-items: center;
    }

    .filter-bar input {
        flex: 1;
        padding: 10px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 16px;
    }

    .filter-bar button {
        margin-left: 10px;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 6px;
        background-color: #007bff;
        color: #fff;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .filter-bar button:hover {
        background-color: #0056b3;
    }

    .pagination {
        margin-top: 20px;
        justify-content: center;
    }
</style>

@php
    $query = DB::table('doctors')
        ->join('specialties', 'doctors.specialty_id', '=', 'specialties.specialty_id')
        ->join('locations', 'doctors.location_id', '=', 'locations.location_id')
        ->select('doctors.*', 'specialties.specialty as specialty_name', 'locations.location_name');

    // Kiểm tra từ khóa tìm kiếm
    if (request()->has('keywords') && !empty(request()->keywords)) {
        $keyword = request()->keywords;
        $query->where('doctors.HoTen', 'like', '%' . $keyword . '%');
    }

    $all_doctors = $query->paginate(8);
@endphp


<div class="container mt-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold text-dark">Danh sách bác sĩ</h2>
    </div>

    <!-- Form tìm kiếm -->
    <div class="filter-bar">
        <form action="{{ url()->current() }}" method="GET" class="d-flex">
            <input type="text" class="form-control" name="keywords" placeholder="Tìm kiếm bác sĩ theo tên..." value="{{ request()->keywords }}">
            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
        </form>
    </div>

    <!-- Danh sách bác sĩ -->
    <div class="doctor-list">
        @foreach ($all_doctors as $doctor)
            <div class="doctor-card">
                <img src="{{ asset('public/backend/images/doctors/' . $doctor->id . '.jpg') }}" 
                     alt="Ảnh bác sĩ" 
                     onError="this.onerror=null;this.src='https://via.placeholder.com/200x250';">
                <div class="doctor-info">
                    <h5>{{ $doctor->HoTen }}</h5>
                    <p><strong>Chức vụ:</strong> {{ $doctor->ChucVu }}</p>
                    <p><strong>Phí khám cơ bản:</strong> {{ number_format($doctor->PhiCoBan, 0, ',', '.') }} VNĐ</p>
                    <p><strong>Chuyên khoa:</strong> {{ $doctor->specialty_name }}</p>
                    <p><strong>Địa điểm làm việc:</strong> {{ $doctor->location_name }}</p>
                </div>
                
            </div>
        @endforeach
    </div>

    <!-- Phân trang -->
    <div class="d-flex pagination">
        {{ $all_doctors->links() }}
    </div>
</div>

@endsection




