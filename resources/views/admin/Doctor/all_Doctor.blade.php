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

            $all_doctors = $query->paginate(5);
        @endphp

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead>
                    <tr class="text-center table-primary">
                        <th>ID</th>
                        <th>Họ Tên</th>
                        <th>Chức Vụ</th>
                        <th>Lương Cơ Bản</th>
                        <th>Chuyên Khoa</th>
                        <th>Địa Điểm</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($all_doctors as $doctors)
                        <tr class="text-center">
                            <td>{{ $doctors->id }}</td>
                            <td>{{ $doctors->HoTen }}</td>
                            <td>{{ $doctors->ChucVu }}</td>
                            <td>{{ number_format($doctors->PhiCoBan, 0, ',', '.') }}</td>
                            <td>{{ $doctors->specialty_id }}</td> <!-- Chỉnh lại theo chuyên khoa -->
                            <td>{{ $doctors->location_id }}</td> <!-- Chỉnh lại theo địa điểm -->
                            <td>
                                <a href="{{ route('admin.edit.doctor', ['id' => $doctors->id]) }}" class="text-success">
                                    <i class="fa fa-pencil-square-o"></i>
                                </a>
                                <a onclick="return confirm('Bạn có muốn xóa không?')" href="{{ route('admin.delete.doctor', ['id' => $doctors->id]) }}" class="text-danger">
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
