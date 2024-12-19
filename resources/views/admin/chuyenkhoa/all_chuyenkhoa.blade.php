@extends("layouts.admin")
@section("content")

<div class="table-agile-info">
    <h3 class="text-center mt-3">DANH SÁCH CHUYÊN KHOA</h3>
    <div class="panel panel-default">
        
        <!-- Form tìm kiếm -->
        <div class="row mb-4">
            <form action="" method="get" class="w-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="col-sm-6 d-flex flex-column">
                        <input type="search" id="keyword" name="keywords" class="form-control" style="width:50%" placeholder="Nhập tên chuyên khoa" value="{{ request()->keywords }}">
                        <button type="submit" id="apply_button" class="btn btn-primary mt-2">Lọc</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Bảng danh sách chuyên khoa -->
        @php
            $query = DB::table('specialties');

            if (request()->has('keywords') && !empty(request()->keywords)) {
                $keyword = request()->keywords;
                $query->where('specialty', 'like', '%' . $keyword . '%');
            }

            $all_chuyenkhoa = $query->paginate(5);
        @endphp

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead>
                    <tr class="text-center table-primary">
                        <th>ID</th>
                        <th>Chuyên khoa</th>
                        <th>Mô tả</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($all_chuyenkhoa as $chuyenkhoa)
                        <tr class="text-center">
                            <td>{{ $chuyenkhoa->specialty_id }}</td>
                            <td>{{ $chuyenkhoa->specialty }}</td>
                            <td>{{ $chuyenkhoa->mota }}</td>
                            <td>
                                <a href="{{ route('admin.edit.chuyenkhoa', ['id' => $chuyenkhoa->specialty_id]) }}" class="text-success">
                                    <i class="fa fa-pencil-square-o"></i>
                                </a>
                                <a onclick="return confirm('Bạn có muốn xóa không?')" href="{{ route('admin.delete.chuyenkhoa', ['id' => $chuyenkhoa->specialty_id]) }}" class="text-danger">
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
    {{ $all_chuyenkhoa->links('pagination::bootstrap-4') }}
</div>

@endsection

<style>
.table {
    border-collapse: collapse;
    font-size: 14px;
    margin: 20px 0;
    box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.1);
}

.table thead th {
    text-transform: uppercase;
    color: white !important;
    text-align: center;
    vertical-align: middle;
    padding: 12px;
    border: 1px solid #000;
    background-color: rgba(153, 41, 41, 0.77) !important;
}

.table tbody td {
    padding: 10px;
    border: 1px solid #dee2e6;
}

.table tbody td a {
    margin: 0 5px;
    font-size: 18px;
}

#apply_button {
    background-color: rgba(153, 41, 41, 0.77);
    margin-left: 10px;
}
</style>
