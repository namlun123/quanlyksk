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

                <!-- Form Edit Chuyên Khoa -->
                <form action="{{ route('admin.update.chuyenkhoa', ['id' => $chuyenkhoa->specialty_id]) }}" method="post">
                    @csrf
                    <div class="container">
                        <div class="text-title-form text-center">CẬP NHẬT CHUYÊN KHOA</div>

                        <!-- Tên Chuyên Khoa -->
                        <div class="form-group">
                            <label for="specialty">Tên chuyên khoa</label>
                            <input type="text" id="specialty" name="specialty" value="{{ $chuyenkhoa->specialty }}" placeholder="Nhập tên chuyên khoa" class="form-control" required>
                        </div>

                        <!-- Mô Tả Chuyên Khoa -->
                        <div class="form-group">
                            <label for="mota">Mô tả</label>
                            <textarea id="mota" name="mota" class="form-control" rows="4" placeholder="Nhập mô tả chuyên khoa" required>{{ $chuyenkhoa->mota }}</textarea>
                        </div>

                        <!-- Nút Cập Nhật -->
                        <div class="btn-container">
                            <button type="submit" class="btn btn-info">Cập nhật chuyên khoa</button>
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
