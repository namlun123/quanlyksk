@extends("layouts.admin")
@section("content")
<!-- Bootstrap DatePicker JavaScript -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type="text/javascript"></script>

<div class="table-agile-info">
    <h3 class="text-center mt-3">DANH SÁCH THÔNG TIN BỆNH NHÂN</h3>
    <div class="panel panel-default">
        
    <div class="row mb-4">
    <form action="" method="get" class="w-100">
        <div class="d-flex justify-content-between align-items-center">
        <div class="col-sm-6 d-flex flex-column">
            <!-- <label for="keyword" class="form-label">Tìm kiếm</label> -->
            <input type="search" id="keyword" name="keywords" class="form-control" style = "width:50%" placeholder="Nhập Email hoặc Mã bệnh nhân" value="{{ request()->keywords }}">
            <button type="submit" id="apply_button" class="btn btn-primary ml-2">Lọc</button>
        </div>

        </div>
    </form>
    </div>


      <!-- <div class="row w3-res-tb">
        <form action="" method="get" class="w-100">
          <div class="d-flex justify-content-start mb-3">
            <div class="col-sm-6">
              <div class="input-group">
                <input type="search" name="keyword" class="form-control" placeholder="Tìm theo Email hoặc Mã thí sinh" value="{{ request()->keyword }}">
                <div class="input-group-append">
                  <button type="submit" id="apply_button" class="btn btn-primary">Lọc</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div> -->

      @php
      $query = DB::table('info_patients');

      if (request()->has('keywords') && !empty(request()->keywords)) {
            $keyword = request()->keywords;
            $query->where('hoten', 'like', '%' . $keyword . '%');
        }

      $all_bn = $query->paginate(5);
      @endphp
     
      <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
          <thead>
            <tr  class="text-center table-primary">
            <th>ID</th>
                        <th>Họ tên</th>
                        <th>Ngày sinh</th>
                        <th>Giới tính</th>
                        <th>Địa chỉ</th>
                        <th>Thành phố</th>
                        <th>Quận</th>
                        <th>Phường</th>
                        <th>Số điện thoại</th>
                        <th>Thao tác</th>
            </tr>
          </thead>
          <tbody>
            @foreach($all_bn as $key => $bn)
            <tr>
                <td>{{$bn->id}}</td>
                <td>{{$bn->HoTen}}</td>
                <td>{{$bn->NgaySinh}}</td>
                <td>
                    {{ $bn->GioiTinh == 1 ? 'Nam' : 'Nữ' }}
                </td>
                <td>{{$bn->DiaChi}}</td>
                <td>{{$bn->province}}</td>
                <td>{{$bn->district}}</td>
                <td>{{$bn->ward}}</td>
                <td>{{$bn->sdt}}</td>
                <td>
                <a href="{{ route('admin.edit.bn', ['id' => $bn->id]) }}" class="active styling-edit" ui-toggle-class="">
                  <i class="fa fa-pencil-square-o text-success text-active"></i></a> 
                <a onclick="return confirm('Bạn có muốn xóa không?')" href="{{ route('admin.delete.bn', ['id' => $bn->id]) }}" class="active styling-edit" ui-toggle-class="" alt="Xóa đăng ký">
                  <i class="fa fa-times text-danger text"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

<div class="d-flex justify-content-center">
    {{ $all_bn->links('pagination::bootstrap-4') }}
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


