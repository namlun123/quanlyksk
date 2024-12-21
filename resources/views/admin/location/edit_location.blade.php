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

                <!-- Form Chỉnh Sửa Location -->
                <form action="{{ route('admin.update.location', ['id' => $location->location_id]) }}" method="post">
                    @csrf
                    <div class="container">
                        <div class="text-title-form text-center">CẬP NHẬT LOCATION</div>

                        <!-- Tên Location -->
                        <div class="form-group">
                            <label for="location_name">Tên Location</label>
                            <input type="text" id="location_name" name="location_name" value="{{ $location->location_name }}" placeholder="Nhập tên location" class="form-control" required>
                        </div>

                        <!-- Địa chỉ Location -->
                        <div class="form-group">
                            <label for="location_address">Địa chỉ</label>
                            <input type="text" id="location_address" name="location_address" value="{{ $location->location_address }}" class="form-control" placeholder="Nhập địa chỉ location" required>
                        </div>

                        <!-- Nút Cập Nhật -->
                        <div class="btn-container">
                            <button type="submit" class="btn btn-info">Cập nhật location</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
/* Chỉnh form container */
.container {
    background-color: #f8f9fa;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 20px;
    max-width: 800px;
    margin: 0 auto;
}

/* Tiêu đề form */
.text-title-form {
    font-size: 1.6rem;
    font-weight: 600;
    color: #2c3e50;
    border-bottom: 2px solid #910734;
    margin-bottom: 20px;
    padding-bottom: 10px;
}

/* Các form-group */
.form-group {
    margin-bottom: 15px;
}

.form-group label {
    font-weight: 600;
    color: #495057;
}

.form-control {
    padding: 8px 12px;
    border: 1px solid #ced4da;
    border-radius: 5px;
}

.btn-info {
    background-color: rgba(153, 41, 41, 0.77) !important;
    border: none !important;
    padding: 10px 20px;
    color: #fff;
    font-weight: 600;
}

.btn-info:hover {
    background-color: rgba(199, 55, 91, 0.93) !important;
}

.btn-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}
</style>
