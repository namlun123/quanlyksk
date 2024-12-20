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

                <!-- Form Edit Loại Xét Nghiệm -->
                <form action="{{ route('admin.update.loaixn', ['id' => $loaixn->xetnghiem_id]) }}" method="post">
                    @csrf
                    <div class="container">
                        <div class="text-title-form text-center">CẬP NHẬT LOẠI XÉT NGHIỆM</div>

                        <!-- Tên Loại Xét Nghiệm -->
                        <div class="form-group">
                            <label for="tenxn">Tên xét nghiệm</label>
                            <input type="text" id="tenxn" name="tenxn" value="{{ $loaixn->tenxn }}" placeholder="Nhập tên xét nghiệm" class="form-control" required>
                        </div>

                        <!-- Nút Cập Nhật -->
                        <div class="btn-container">
                            <button type="submit" class="btn btn-info">Cập nhật xét nghiệm</button>
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