@extends('layout')
@section('content')

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f8f9fa;
        }
        .doctor-list {
            max-width: 900px;
            margin: auto;
        }
        .doctor-card {
            display: flex;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .doctor-card img {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
        .doctor-info {
            padding: 15px;
            flex: 1;
        }
        .doctor-info h4 {
            margin: 0;
            font-size: 18px;
            color: #007bff;
        }
        .doctor-info p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }
        .doctor-actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        .doctor-actions a {
            text-decoration: none;
            padding: 8px 12px;
            font-size: 14px;
            border-radius: 4px;
            text-align: center;
        }
        .btn-book {
            background-color: #007bff;
            color: #fff;
            border: none;
        }
        .btn-details {
            background-color: #17a2b8;
            color: #fff;
            border: none;
        }
        .filter-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .filter-bar select {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        
    </style>

@php
    // Lấy danh sách bác sĩ với thông tin chuyên khoa thông qua join
    $query = DB::table('doctors')
        ->join('specialties', 'doctors.specialty_id', '=', 'specialties.specialty_id')
        ->select('doctors.*', 'specialties.specialty as specialty_name'); // Chọn thông tin bác sĩ và chuyên khoa

    // Kiểm tra nếu có từ khóa tìm kiếm
    if (request()->has('keywords') && !empty(request()->keywords)) {
        $keyword = request()->keywords;
        $query->where('doctors.HoTen', 'like', '%' . $keyword . '%');
    }

    $all_doctors = $query->paginate(10);
@endphp

        <div class="container mt-5">
    <!-- Tiêu đề -->
    <div class="text-center mb-4">
        <h2 class="fw-bold text-dark">Danh sách bác sĩ</h2>
    </div>

<!-- Form tìm kiếm -->
<div class="filter-bar mb-4">
    <form action="{{ url()->current() }}" method="GET" class="w-100">
        <div class="input-group d-flex align-items-center">
            <input type="text" class="form-control" name="keywords" placeholder="Tìm kiếm bác sĩ theo tên..." value="{{ request()->keywords }}">
            <button class="btn btn-primary ms-2" type="submit" style="margin-top:10px;">Tìm kiếm</button>
        </div>
    </form>
</div>


    <!-- Danh sách bác sĩ -->
    <div class="row">
        @foreach ($all_doctors as $doctor)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="row g-0">
                        <div class="col-md-4">
                        <img src="{{ asset('public/backend/images/doctors/' . $doctor->id . '.jpg') }}" 
     alt="Ảnh bác sĩ" class="img-fluid rounded-start" 
     width="120" height="150"
     style="margin-right: 10px; margin-bottom: 10px;" 
     onError="this.onerror=null;this.src='https://via.placeholder.com/100';">


                </div>

                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">{{ $doctor->HoTen }}</h5>
                                <p class="card-text">{{ $doctor->ChucVu }}</p>  
                                <p class="card-text"><strong>Chuyên khoa:</strong> {{ $doctor->specialty_name }}</p> <!-- Hiển thị chuyên khoa -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Phân trang -->
    <div class="d-flex justify-content-center mt-4">
        {{ $all_doctors->links() }}
    </div>
</div>

@endsection