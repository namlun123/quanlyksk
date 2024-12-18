@extends('layouts.admin')
@section('content')

   <style>
    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
        background-color: white;
        text-align: center !important;
    }

    .table thead {
        background-color: rgba(153, 41, 41, 0.77);
    }

    .table th,
    .table td {
        padding: 8px;
        text-align: left;
        vertical-align: middle;
        border: 1px solid #dee2e6;
    }

    .table th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .table tbody {
        text-align: center; /* Căn giữa cho các ô trong phần thân bảng */
    }
</style>
<table class="table">
    <thead>
        <tr>
            <th>Mã hồ sơ</th>
            <th>Mã bệnh nhân</th>
            <th>Tên bệnh nhân</th>
            <th>Mã kết quả xét nghiệm</th>
            <th>Tên xét nghiệm</th>
            <th>Kết quả</th>
            <th>Ngày khám</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ketquaDetails as $detail)
        <tr>
            <td>{{ $detail->mahs }}</td>
            <td>{{ $detail->mabn }}</td>
            <td>{{ $detail->ht }}</td>
            <td>{{ $detail->makq }}</td>
            <td>{{ $detail->tenxn }}</td>
            <td>{{ $detail->kq }}</td>
            <td>{{ $detail->date }}</td>
            <td>
                 <a href="{{ route('admin.edit.kq', ['id' => $detail->mahs]) }}" class="active styling-edit" ui-toggle-class="">
                  <i class="fa fa-pencil-square-o text-success text-active"></i></a> 
                <a onclick="return confirm('Bạn có muốn xóa không?')" href="{{ route('admin.delete.kq', ['id' => $detail->makq]) }}" class="active styling-edit" ui-toggle-class="" alt="Xóa đăng ký"> 
                  <i class="fa fa-times text-danger text"></i></a>
                  
              </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-center">
    
</div>
<div class="d-flex justify-content-center">
                <a href="{{ route('admin.kq', ['id' => $detail->mahs]) }}" class="btn btn-primary ml-2">Quay về</a>
                    <!-- <form action="{{ route('admin.export.pdf', ['enrollId' => $ketquaDetails[0]->mahs]) }}" method="POST" class="d-inline-flex">
                        @csrf
                        <button type="submit" style="margin-top: 10px"; class="btn btn-primary ml-2">Xuất PDF</button>
                    </form> -->
                    <a href="{{ route('admin.export.pdf', ['enrollId' => $ketquaDetails[0]->mahs]) }}"  target="_blank" class="btn btn-primary ml-2">Xuất PDF</a>

                </div>
                
@endsection
