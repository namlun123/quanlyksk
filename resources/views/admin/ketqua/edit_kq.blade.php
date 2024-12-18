@extends('layouts.admin')
@section('content')
<div class="container py-2">
    <div class="mb-4">
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
            <form action="{{ route('admin.update.kq', ['id' => $id]) }}" method="POST">
                @csrf
                @method('PUT')
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            @php
                            $all_kq = DB::table('loaixn')->get(); // Truy xuất tất cả các mã xét nghiệm từ bảng loaixn

                            @endphp
                            <th>Mã xét nghiệm</th>
                            <th>Kết quả</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kq as $result)
                        <tr>
                            <td>
                                <select name="xn_id[]" class="form-control" required data-id="{{ $result->makq }}">
                                    @foreach ($all_kq as $option)
                                    <option value="{{ $option->xetnghiem_id }}" {{ $option->xetnghiem_id == $result->xn_id ? 'selected' : '' }}>
                                            {{ $option->xetnghiem_id }} - {{ $option->tenxn }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                          
                            <td>
                                <input type="text" name="ketqua[]" class="form-control" value="{{ $result->kq }}" required>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    <a href="{{ route('admin.view.kq', ['id' => $id]) }}" class="btn btn-primary ml-2">Quay về</a>
                </div>



            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('select[name="xn_id[]"]').on('change', function() {
        var selectedID = $(this).val();
        var currentRow = $(this).closest('tr');
        
        // Lấy tên loại xét nghiệm theo mã xetnghiem_id
        // var tenxn = $(this).find('option:selected').text();
        
        // Đặt tên loại xét nghiệm vào input tương ứng
       // currentRow.find('input[name="tenxn[]"]').val(tenxn);
    });
});
</script>
