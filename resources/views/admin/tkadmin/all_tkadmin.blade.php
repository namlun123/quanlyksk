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
    <h3 class="text-center mt-3">DANH SÁCH TÀI KHOẢN ADMIN</h3>
    <div class="panel panel-default">
        <div class="row mb-4">
            <form action="" method="get" class="w-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="col-sm-6 d-flex flex-column">
                        <input type="search" id="keyword" name="keyword" class="form-control" style="width:50%" placeholder="Nhập Email hoặc Mã Admin" value="{{ request()->keyword }}">
                        <button type="submit" id="apply_button" class="btn btn-primary ml-2">Lọc</button>
                    </div>
                </div>
            </form>
        </div>

        @php
        $query = DB::table('admins');
        if (request()->has('keyword') && !empty(request()->keyword)) {
            $keyword = request()->keyword;
            $query->where(function($query) use ($keyword) {
                $query->where('email', 'like', '%' . $keyword . '%')
                      ->orWhere('admin_id', 'like', '%' . $keyword . '%');
            });
        }
        $all_tkadmin = $query->paginate(10);
        @endphp

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead>
                    <tr class="text-center table-primary">
                        <th>ID</th>
                        <th>Email</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($all_tkadmin as $key => $tkadmin)
                    <tr>
                        <td>{{$tkadmin->id}}</td>
                        <td>{{$tkadmin->email}}</td>
                        <td>
                            <a onclick="return confirm('Bạn có muốn xóa không?')" href="{{ route('admin.delete.tkadmin', ['id' => $tkadmin->id]) }}" class="active styling-edit" ui-toggle-class="" alt="Xóa đăng ký">
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
    {{ $all_tkadmin->links('pagination::bootstrap-4') }}
</div>

@endsection

<style>
    .row.mb-4 {
        margin-bottom: 5px;
    }
    .col-sm-6 {
        display: flex;
        align-items: center;
        width: 100%;
        padding-top: 30px;
        padding-bottom: 30px;
    }

    /* Tổng thể bảng */
    .table {
        border-collapse: collapse;
        font-size: 14px;
        margin: 20px 0;
        box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.1);
    }

    /* Định dạng header */
    .table thead th {
        text-transform: uppercase;
        color: white !important;
        text-align: center;
        vertical-align: middle;
        padding: 12px;
        border: 1px solid rgb(6, 7, 7);
        background-color: rgba(153, 41, 41, 0.77) !important;
    }

    /* Dòng của bảng */
    .table tbody tr {
        transition: all 0.3s ease-in-out;
    }

    /* Định dạng các ô trong bảng */
    .table tbody td {
        padding: 10px;
        border: 1px solid #dee2e6;
        color: #000 !important;
        text-align: center;
    }

    /* Định dạng các biểu tượng sửa/xóa */
    .table tbody td a {
        margin: 0 5px;
        font-size: 18px;
    }

    .table tbody td a:hover {
        color: #0056b3;
    }

    /* Hiệu ứng cho cột ID và Mã bệnh nhân */
    .table tbody td:first-child,
    .table tbody td:nth-child(4) {
        font-weight: bold;
    }

    #apply_button {
        background-color: rgba(153, 41, 41, 0.77);
        margin-left: 10px;
    }
</style>
