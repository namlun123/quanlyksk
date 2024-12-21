@extends("layouts.admin")
@section("content")

<div class="table-agile-info">
    <h3 class="text-center mt-3">DANH SÁCH BÁC SĨ</h3>
    <div class="panel panel-default">
        
        <!-- Form tìm kiếm -->
        <div class="row mb-4">
            <form action="" method="get" class="w-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="col-sm-6 d-flex flex-column">
                        <input type="search" id="keyword" name="keywords" class="form-control" style="width:50%" placeholder="Nhập tên bác sĩ" value="{{ request()->keywords }}">
                        <button type="submit" id="apply_button" class="btn btn-primary mt-2">Lọc</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Bảng danh sách Bác Sĩ -->
        @php
            $query = DB::table('doctors');

            if (request()->has('keywords') && !empty(request()->keywords)) {
                $keyword = request()->keywords;
                $query->where('HoTen', 'like', '%' . $keyword . '%');
            }

            $all_doctors = $query->paginate(6);
        @endphp

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead>
                    <tr class="text-center table-primary">
                        <th>ID</th>
                        <th>Họ Tên</th>
                        <th>Chức Vụ</th>
                        <th>Phí Cơ Bản</th>
                        <th>Chuyên Khoa</th>
                        <th>Địa Điểm</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($doctors as $doctor)
    <tr class="text-center">
        <td>{{ $doctor->id }}</td>
        <td>{{ $doctor->HoTen }}</td>
        <td>{{ $doctor->ChucVu }}</td>
        <td>{{ number_format($doctor->PhiCoBan, 0, ',', '.') }}</td>
        <td>
            @if($doctor->Chuyenkhoa)
                {{ $doctor->Chuyenkhoa->specialty }}
            @endif
        </td>
        <td>
            @if($doctor->location)
                {{ $doctor->location->location_name }}
            @endif
        </td>
        <td>
            <a href="{{ route('admin.edit.doctor', ['id' => $doctor->id]) }}" class="text-success">
                <i class="fa fa-pencil-square-o"></i>
            </a>
            <a onclick="return confirm('Bạn có muốn xóa không?')" href="{{ route('admin.delete.doctor', ['id' => $doctor->id]) }}" class="text-danger">
                <i class="fa fa-times"></i>
            </a>
        </td>
    </tr>
@endforeach


</tbody>

            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center">
    {{ $all_doctors->links('pagination::bootstrap-4') }}
</div>

@endsection


<style>
 .row.mb-4 {
        margin-bottom: 5px; /* Điều chỉnh khoảng cách giữa các hàng */
    }
  .col-sm-6 {
    display: flex;
    align-items: center;
    width: 100%;
    padding-top:30px;
    padding-bottom:30px;
  }
/* Tổng thể bảng */
.table {
    border-collapse: collapse; /* Gộp đường viền */
    font-size: 14px; /* Cỡ chữ */
    margin: 20px 0; /* Khoảng cách của bảng */
    box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.1) ; /* Đổ bóng nhẹ */

}

/* Định dạng header */
.table thead th {
    text-transform: uppercase;
    color: white !important; /* Màu chữ cho header */
    text-align: center; /* Chữ căn giữa ngang */
    vertical-align: middle; /* Căn giữa theo chiều dọc */
    padding: 12px; /* Khoảng cách bên trong */
    border: 1px solid rgb(6, 7, 7) ; /* Đường viền */
    background-color:rgba(153, 41, 41, 0.77) !important;
}

/* Dòng của bảng */
.table tbody tr {
    transition: all 0.3s ease-in-out; /* Hiệu ứng hover */
}

/* Định dạng các ô trong bảng */
.table tbody td {
    padding: 10px; /* Khoảng cách bên trong */
    border: 1px solid #dee2e6; /* Đường viền */
    color: #000 !important;
}

/* Định dạng các biểu tượng sửa/xóa */
.table tbody td a {
   
    margin: 0 5px; /* Khoảng cách giữa các biểu tượng */
    font-size: 18px; /* Kích thước icon */
}

.table tbody td a:hover {
    color: #0056b3; /* Màu khi hover */
}

/* Hiệu ứng cho cột ID và Mã bệnh nhân */
.table tbody td:first-child, 
.table tbody td:nth-child(4) {
    font-weight: bold; /* Chữ đậm */
}
  #apply_button {
    background-color: rgba(153, 41, 41, 0.77);
    margin-left: 10px; /* Điều chỉnh khoảng cách giữa trường nhập liệu và nút lọc */
  }
</style>