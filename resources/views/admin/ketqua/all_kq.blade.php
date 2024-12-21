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
    <h3 class="text-center mt-3">DANH SÁCH KẾT QUẢ</h3>
    <p class="text-muted text-center" style="margin:10px 10px; font-size: 14px; color: #888; font-style:italic;">(Chỉ hiển thị những hồ sơ đã có kết quả xét nghiệm)</p>
    <div class="panel panel-default">
        
    <div class="row mb-4">
      <form action="" method="get" class="w-100">
      <div class="d-flex justify-content-between align-items-center">
          <div class="col-sm-6 d-flex flex-column">
              <label for="filter" class="form-label">Theo</label>
              <div class="d-flex">
                  <select id="filter" name="filter" class="form-control" style="width:90%; margin-left:10px;">
                      <option value="id" {{ request('filter') == 'id' ? 'selected' : '' }}>Mã hồ sơ</option>
                      <option value="patient_id" {{ request('filter') == 'patient_id' ? 'selected' : '' }}>Mã bệnh nhân</option>
                  </select>
              </div>
              <label for="keyword" class="form-label mt-2" style="white-space: nowrap;margin-left:5px;">Từ khóa</label>
              <div class="d-flex">
                  <input type="search" id="keyword" name="keyword" class="form-control" style="width:80%; margin-left:10px;" value="{{ request()->keyword ?? '' }}">
              </div>
              <button type="submit" id="apply_button" class="btn btn-primary mt-2">Lọc</button>
              <div class="col-md-3 d-flex align-items-end">
                    <a href="{{ url()->current() }}" id="show_all_button" class="btn btn-secondary w-100">Hiển thị tất cả</a>
                </div>
          </div>
      </div>
  </form>


    </div>
    @php
$all_kq = DB::table('info_patients')
    ->join('patients', 'info_patients.id', '=', 'patients.user_id')
    ->join('enrolls', 'patients.user_id', '=', 'enrolls.patient_id')
    ->join('ketqua', 'enrolls.id', '=', 'ketqua.hoso_id') // Join bảng ketqua
    ->select(
        'enrolls.id as mahs',                 // Mã hồ sơ
        DB::raw('MAX(info_patients.HoTen) as ht'), // Tên bệnh nhân (dùng MAX hoặc bất kỳ hàm tổng hợp nào vì giá trị đã nhóm)
        'patients.user_id as mabn',          // Mã bệnh nhân
        DB::raw('GROUP_CONCAT(ketqua.xn_id) as xn_ids'), // Danh sách các xn_id
        'enrolls.status',                    // Trạng thái
        'enrolls.date'                       // Ngày khám
    )
    ->whereNotNull('ketqua.xn_id') // Chỉ lấy hồ sơ có kết quả xét nghiệm
    ->groupBy('enrolls.id', 'patients.user_id', 'enrolls.status', 'enrolls.date') // Nhóm theo các cột cần thiết
    ->orderBy('enrolls.id', 'asc') // Sắp xếp theo ID tăng dần
    ->when(request()->has('keyword') && !empty(request()->keyword), function ($query) {
        $keyword = '%' . request()->keyword . '%';
        $filter = request('filter'); // Giá trị filter từ request

        if ($filter === 'id') {
            $query->where('enrolls.id', 'like', $keyword);
        } elseif ($filter === 'patient_id') {
            $query->where('patients.user_id', 'like', $keyword);
        } elseif ($filter === 'all') {
            // Điều kiện lọc cả 'mã bệnh nhân' và 'mã hồ sơ'
            $query->where(function($query) use ($keyword) {
                $query->where('enrolls.id', 'like', $keyword)
                      ->orWhere('patients.user_id', 'like', $keyword);
            });
        }
    })
    ->paginate(5);
@endphp

      <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
          <thead>
            <tr  class="text-center table-primary">
              <th>Mã hồ sơ</th>
              <th>Mã bệnh nhân</th>
              <th>Tên bệnh nhân</th>
              <th>Ngày khám</th>
              <th>Thao tác</th>
            </tr>
          </thead>
          <tbody>

            @foreach($all_kq as $key => $khs)
            
            <tr>
                <td>{{$khs->mahs}}</td>
                <td>{{$khs->mabn}}</td>
                <td>{{$khs->ht}}</td>
                <td>{{$khs->date}}</td>
                <td>
                  <!-- Kiểm tra xem hồ sơ có kết quả xét nghiệm hay không -->
        @if($khs->mahs === null)
            <!-- Hiển thị thông báo nếu hồ sơ không có kết quả xét nghiệm -->
            <span class="text-danger">Hồ sơ chưa có kết quả xét nghiệm</span>
        @else
        <a href="javascript:void(0)" onclick="checkResult({{ $khs->mahs }})" class="active styling-view" ui-toggle-class="">
                <i class="fa fa-eye text-primary"></i>
            </a>
                 <a href="{{ route('admin.edit.kq', ['id' => $khs->mahs]) }}" class="active styling-edit" ui-toggle-class="">
                  <i class="fa fa-pencil-square-o text-success text-active"></i></a> 
                  @endif
                <!-- <a onclick="return confirm('Bạn có muốn xóa không?')" href="{{ route('admin.delete.kq', ['id' => $khs->mahs]) }}" class="active styling-edit" ui-toggle-class="" alt="Xóa đăng ký"> 
                  <i class="fa fa-times text-danger text"></i></a> -->
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
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
    border: 1px solid rgba(153, 41, 41, 0.77); /* Đường viền */
    color: #000 !important;
    text-align: center;
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
</style>
<script type="text/javascript">
    function checkResult(mahs) {
        // Kiểm tra xem hồ sơ có kết quả xét nghiệm hay không
        if (mahs === null) {
            alert('Hồ sơ chưa có kết quả xét nghiệm');
        } else {
            window.location.href = "{{ route('admin.view.kq', ['id' => ':mahs']) }}".replace(':mahs', mahs);
        }
    }
</script>