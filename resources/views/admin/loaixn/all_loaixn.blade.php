@extends("layouts.admin")
@section("content")

<div class="table-agile-info">
    <h3 class="text-center mt-3">DANH SÁCH LOẠI XÉT NGHIỆM</h3> <br>
    <div class="panel panel-default">
        
        <!-- Form tìm kiếm -->
        <div class="row mb-4">
    <form action="" method="get" class="w-100">
        <div class="d-flex justify-content-between align-items-center">
            <div class="col-sm-6 d-flex flex-column">
                <div class="col-md-10">
                <label for="keyword" class="form-label">Nhập tên loại xét nghiệm</label>
                <input type="search" id="keyword" name="keywords" class="form-control" style="width:100%" placeholder="Nhập tên loại xét nghiệm" value="{{ request()->keywords }}">
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" id="apply_button" class="btn btn-primary w-100">Lọc</button>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <a href="{{ url()->current() }}" id="show_all_button" class="btn btn-secondary w-100">Hiển thị tất cả</a>
                </div>
            </div>
        </div>
    </form>
</div>

        <!-- Bảng danh sách loại xét nghiệm -->
        @php
            $query = DB::table('loaixn');

            if (request()->has('keywords') && !empty(request()->keywords)) {
                $keyword = request()->keywords;
                $query->where('tenxn', 'like', '%' . $keyword . '%');
            }

            $all_loaixn = $query->paginate(5);
        @endphp

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead>
                    <tr class="text-center table-primary">
                        <th>ID</th>
                        <th>Tên loại xét nghiệm</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($all_loaixn as $loaixn)
                        <tr class="text-center">
                            <td>{{ $loaixn->xetnghiem_id }}</td>
                            <td>{{ $loaixn->tenxn }}</td>
                            <td>
                                <a href="{{ route('admin.edit.loaixn', ['id' => $loaixn->xetnghiem_id]) }}" class="text-success">
                                    <i class="fa fa-pencil-square-o"></i>
                                </a>
                                <a onclick="return confirm('Bạn có muốn xóa không?')" href="{{ route('admin.delete.loaixn', ['id' => $loaixn->xetnghiem_id]) }}" class="text-danger">
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
    {{ $all_loaixn->links('pagination::bootstrap-4') }}
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
#apply_button, #show_all_button {
    background-color: rgba(153, 41, 41, 0.77); /* Màu nền */
    color: white; /* Màu chữ */
    border: none; /* Loại bỏ viền */
    padding: 8px 16px; /* Khoảng cách trong */
    border-radius: 4px; /* Bo góc */
    font-size: 14px; /* Cỡ chữ */
    cursor: pointer; /* Con trỏ */
    transition: background-color 0.3s ease; /* Hiệu ứng hover */
}

/* Hiệu ứng hover */
#apply_button:hover, #show_all_button:hover {
    background-color: #990000; /* Màu nền khi hover */
}

/* Đảm bảo nút Hiển thị tất cả nằm ngay cạnh nút Lọc */
#apply_button + #show_all_button {
    margin-left: 5px; /* Khoảng cách nhỏ giữa hai nút */
}

/* Đồng bộ kích thước form */
#keyword {
    width: 50%; /* Đảm bảo kích thước đồng bộ */
    margin-bottom: 10px; /* Khoảng cách dưới */
}

</style>
