@extends("layouts.admin")
@section("content")
<!-- Bootstrap DatePicker JavaScript -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type="text/javascript"></script>

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
                 <!-- Form để thêm chuyên khoa -->
            <form action="{{ route('admin.save.chuyenkhoa') }}" method="POST">
                @csrf
                <div class="container">
                    <div class="text-title-form text-center">THÊM MỚI CHUYÊN KHOA</div>

                    <!-- Tên chuyên khoa -->
                    <div class="form-group">
                        <label for="specialty">Tên chuyên khoa</label>
                        <input type="text" id="specialty" name="specialty" class="form-control" placeholder="Nhập tên chuyên khoa" required>
                    </div>

                    <!-- Mô tả chuyên khoa -->
                    <div class="form-group">
                        <label for="mota">Mô tả</label>
                        <textarea id="mota" name="mota" class="form-control" rows="4" placeholder="Nhập mô tả chuyên khoa" required></textarea>
                    </div>

                    <!-- Nút submit -->
                    <div class="btn-container">
                        <button type="submit" class="btn btn-info">Thêm chuyên khoa</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

<style>
.container {
    background-color: #f8f9fa;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 20px;
    max-width: 800px;
    margin: 0 auto;
}

.text-title-form {
    font-size: 1.6rem;
    font-weight: 600;
    color: #2c3e50;
    border-bottom: 2px solid #910734;
    margin-bottom: 20px;
    padding-bottom: 10px;
}

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