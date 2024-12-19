@extends("layouts.admin")
@section("content")
<!-- Bootstrap DatePicker JavaScript -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type="text/javascript"></script>
<style>

label.required:after {
    content: "*";
    font-size: 0.8em;
    margin: 0.3em;
    position: relative;
    top: -2px;
    color: red;
}
</style>
  <div style="min-height:48vh">

    <style>
        #Image3x4{
            z-index:-1;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('public/frontend/css/normal-exam.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/coppie/croppie.min.css') }}">
    <style>
        label.cabinet{
        display: block;
        cursor: pointer;
    }

    label.cabinet input.file{
        position: relative;
        height: 100%;
        width: auto;
        opacity: 0;
        -moz-opacity: 0;
      filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
      margin-top:-30px;
    }

    #upload-demo{
        width: 100%;
            height: 550px;
      padding-bottom:25px;
    }
     .text-color-orange{
         color:#F25A18;
     }
    </style>
    <div class="container">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>
    <div class="container py-2">
        <div class=" mb-4">
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
                    <form action="{{ route('admin.add.kq.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <h4 class="text-uppercase text-center text-title-form" style="margin-bottom: 10px; font-size: 26px;">THÔNG TIN KẾT QUẢ KHÁM</h4>
                            <p class="text-muted text-center" style="margin-bottom: 20px; font-size: 14px; color: #888; font-style:italic;">(Chỉ hiển thị những bệnh nhân đã có hồ sơ khám)</p>

                            <div class="col-lg-5">
                                <div class="row col-lg-12 d-flex justify-content-center align-items-center">
                                    <div class="form-group col-lg-12">
                                        <!-- Chọn bệnh nhân -->
                                        <label class="form-label mb-1 text-2 required">Chọn bệnh nhân</label>
                                        @php
                                        $all_infor = DB::table('info_patients')
                                            ->join('patients', 'info_patients.id', '=', 'patients.user_id')
                                            ->join('enrolls', 'patients.user_id', '=', 'enrolls.patient_id') // Joins with enrolls to check if a patient has any records
                                            ->select(
                                                'info_patients.id as bn_id',
                                                'info_patients.*',
                                                'patients.*',
                                                'info_patients.DiaChi',
                                                DB::raw('MAX(info_patients.province) as province'), // Hoặc MIN hoặc bất kỳ hàm tổng hợp nào
                                                'info_patients.district', 
                                                'info_patients.ward',
                                                'info_patients.sdt',
                                                'info_patients.created_at',
                                                'info_patients.updated_at',
                                                'info_patients.created_by',
                                                'patients.id as patient_id',
                                                'patients.email',
                                                'patients.password',
                                                'patients.user_id',
                                                'patients.created_at as patient_created_at',
                                                'patients.updated_at as patient_updated_at',
                                                'patients.created_by as patient_created_by'
                                            )
                                            ->groupBy(
                                                'info_patients.id', 
                                                'info_patients.HoTen', 
                                                'info_patients.NgaySinh', 
                                                'info_patients.GioiTinh', 
                                                'info_patients.DiaChi', 
                                                'info_patients.province', 
                                                'info_patients.district', 
                                                'info_patients.ward', 
                                                'info_patients.sdt', 
                                                'info_patients.created_at', 
                                                'info_patients.updated_at', 
                                                'info_patients.created_by',
                                                'patients.id', 
                                                'patients.email', 
                                                'patients.password', 
                                                'patients.user_id', 
                                                'patients.created_at', 
                                                'patients.updated_at', 
                                                'patients.created_by'
                                            )
                                            ->get();
                                    @endphp



                                        <select class="form-select form-control h-auto py-2" id="bn" name="bn" required data-msg-required="Vui lòng chọn bệnh nhân">
                                            <option value="0" selected>Chọn bệnh nhân</option>
                                            @foreach($all_infor as $infor)
                                                <option value="{{ $infor->bn_id }}">{{ $infor->bn_id }} - {{ $infor->HoTen }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @php
                                        $hoso = DB::table('enrolls')
                                            ->join('patients', 'enrolls.patient_id', '=', 'patients.user_id')
                                            ->select('enrolls.id as hoso_id') // chỉ lấy cột id của enrolls
                                            ->get();
                                    @endphp
                                    <div class="form-group col-lg-12">
                                        <label for="hs">Mã hồ sơ</label>
                                        <select name="hs" id="hs" class="form-control" required>
                                            <option value="0" selected>Chọn mã hồ sơ</option>
                                            @foreach($hoso as $hs)
                                                <option value="{{ $hs->hoso_id }}">{{ $hs->hoso_id }}</option>
                                            @endforeach
                                        </select>
                                        <span id="error-message" style="color: red; display: none;">Bệnh nhân này chưa có hồ sơ khám.</span>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label class="form-label mb-1 text-2 required">Họ và tên bệnh nhân</label>
                                        <input readonly type="text" value="" class="form-control text-3 h-auto py-2" name="hoten" placeholder="Nhập họ và tên bệnh nhân" aria-invalid="true" maxlength="255" required data-msg-required="Vui lòng nhập họ và tên bệnh nhân" data-rule-pattern="^[a-zA-Z_ÀÁÂÃÈÉÊẾÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêếìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹý\ ]+$" data-msg-pattern="Tên không đúng định dạng">
                                    </div>
                                    <div class="form-group col-lg-12 row">
                                        <div class="form-group col-lg-6">
                                            <label class="form-label mb-1 text-2 required">Ngày sinh</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control text-3 h-auto py-2 type-date" name="ngaysinh" id="BirthDay" placeholder="YYYY/MM/DD" required>
                                                <label class="input-group-text" for="BirthDay"><i class="fas fa-calendar-alt"></i></label>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label class="form-label mb-1 text-2 required">Giới tính</label>
                                            <div class="d-inline">
                                                <div class="col-lg-6 form-check form-check-inline">
                                                    <input disabled class="form-check-input" type="radio" name="gioitinh" id="1" value="1" required>
                                                    <label class="form-check-label" for="1">Nam</label>
                                                </div>
                                                <div class="col-lg-6 form-check form-check-inline">
                                                    <input disabled class="form-check-input" type="radio" name="gioitinh" id="0" value="0">
                                                    <label class="form-check-label" for="0">Nữ</label>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label class="form-label mb-1 text-2 required">Số nhà, đường/phố</label>
                                        <input readonly type="text" value="" class="form-control text-3 h-auto py-2" placeholder="Nhập số nhà, đường/phố/phường/quận/thành phố" name="diachi" required maxlength="255" data-msg-required="Vui lòng nhập thông tin số nhà, đường phố">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="form-group col-lg-4">
                                        <label class="form-label mb-1 text-2 required" for="city">Tỉnh/Thành phố</label>
                                        <select class="form-select form-control h-auto py-2" id="city" name="province" required data-msg-required="Vui lòng chọn Tỉnh/Thành phố">
                                            <option name="province" value="" selected></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label class="form-label mb-1 text-2 required" for="district">Quận/Huyện</label>
                                        <select class="form-select form-control h-auto py-2" id="district" name="district" required data-msg-required="Vui lòng chọn Quận/Huyện">
                                            <option name="district" value="" selected></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label class="form-label mb-1 text-2 required" for="ward">Phường/Xã</label>
                                        <select class="form-select form-control h-auto py-2" id="ward" name="ward" required data-msg-required="Vui lòng chọn Xã/Phường">
                                            <option name="ward" value="" selected></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label class="form-label mb-1 text-2 required">Số điện thoại</label>
                                        <input readonly class="form-control text-3 h-auto py-2" type="text" name="sdt" placeholder="Nhập số điện thoại" required data-msg-required="Vui lòng nhập số điện thoại" data-rule-minlength="10" maxlength="10" data-msg-minlength="Số điện thoại phải đủ 10 số" data-rule-number="^[0-9]{10}" data-msg-number="validate.Phone.pattern">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label class="form-label mb-1 text-2 required">Email</label>
                                        <input readonly type="text" value="" class="form-control text-3 h-auto py-2" name="email" data-msg-required="Vui lòng nhập email" placeholder="Nhập email" maxlength="255" data-rule-pattern="^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$" data-msg-pattern="Vui lòng nhập email đúng định dạng" required="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Nút mở Modal -->
                            <button type="button" style ="background-color: #992929C4; margin-bottom: 10px;" class="btn btn-info" data-toggle="modal" data-target="#addKqModal">
                                Thêm mới kết quả xét nghiệm
                            </button>

                        <!-- Bảng Chi Tiết -->
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered" id="kqTable">
                                <thead>
                                    <tr >
                                        <th style="text-align: center;">Loại xét nghiệm</th>
                                        <th style="text-align: center;">Kết quả</th>
                                        <th style="text-align: center;">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody id="resultBody" style="text-align: center;">
                                    <!-- Các hàng dữ liệu sẽ được thêm ở đây -->
                                </tbody>
                            </table>
                        </div>
                        <!-- Ẩn input để truyền giá trị xetnghiem_id vào form action -->
                        <input type="hidden" name="xetnghiem_id_hidden" id="xetnghiem_id_hidden" value="">
                        <input type="hidden" name="ketqua_hidden" id="ketqua_hidden" value="">
                        <div class="mt-4">
                            <button type="submit" style ="background-color: #992929C4;" class="btn btn-primary">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal -->
<div class="modal fade" id="addKqModal" tabindex="-1" role="dialog" aria-labelledby="addKqModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addKqModalLabel">Thêm mới kết quả</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form nhập dữ liệu -->
                <form id="addKqForm">
                    @csrf
                    <div class="form-group">
                        <label for="modal_xetnghiem_id">Loại xét nghiệm</label>
                        <select name="xetnghiem_id" id="modal_xetnghiem_id" class="form-control">
                            @foreach($xetnghiem as $x)
                                <option value="{{ $x->xetnghiem_id }}">{{ $x->xetnghiem_id }} - {{ $x->tenxn }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="modal_ket_qua">Kết quả</label>
                        <input type="text" name="ket_qua" id="modal_ket_qua" class="form-control" required>
                    </div>
                   
                    <button type="submit" class="btn btn-primary">Lưu kết quả</button>
                </form>
            </div>
        </div>
    </div>
</div>
        <script>
            $(document).ready(function() {
                $('#bn').change(function() {
                    var bnId = $(this).val();
                    if (bnId != 0) {
                        $.ajax({
                            url: '{{ URL::to('/get-thong-tin-bn/') }}/' + bnId,
                            type: 'GET',
                            dataType: "json",
                            responseType: "json",
                            success: function(data) {
                                var bn = data.bn;
                                var khs = data.kh;
                                var hoso = data.hs;
                                // var hoso = data.hs;
                                var gioiTinh = bn.GioiTinh;
                                $('input[name="hoten"]').val(bn.HoTen);
                                $('input[name="ngaysinh"]').val(bn.NgaySinh);
                                $('input[name="diachi"]').val(bn.DiaChi);
                                $('input[name="sdt"]').val(bn.sdt);
                                $('input[name="email"]').val(khs.email);
                                $('#city option[name="province"]').val(bn.province);
                                $('#city option:selected').text(bn.province);
                                $('#district option[name="district"]').val(bn.district);
                                $('#district option:selected').text(bn.district);
                                $('#ward option[name="ward"]').val(bn.ward);
                                $('#ward option:selected').text(bn.ward);
                                if (gioiTinh === 1) {
                                    $('#1').prop('checked', true);
                                } else {
                                    $('#0').prop('checked', true);
                                }
                            // Điền dropdown hồ sơ với dữ liệu mới
                                var hosoDropdown = $('#hs');
                                hosoDropdown.empty(); // Xóa dữ liệu cũ
                                if (hoso.length > 0) {
                                    hoso.forEach(function(h) {
                                        hosoDropdown.append('<option value="' + h.hoso_id + '">' + h.hoso_id + '</option>');
                                    });
                                } else {
                                    hosoDropdown.append('<option value="0" selected>Không có hồ sơ</option>');
                                }
                            },
                            error: function() {
                                alert('Đã xảy ra lỗi khi lấy thông tin bệnh nhân');
                            }
                        });
                    } else {
                        $('input[name="hoten"]').val('');
                        $('input[name="ngaysinh"]').val('');
                        $('input[name="diachi"]').val('');
                        $('input[name="sdt"]').val('');
                        $('input[name="email"]').val('');
                        $('input[name="gioitinh"]').prop('checked', false);
                        $('#1').val('');
                        $('#0').val('');
                        $('#city option[name="province"]').val('');
                        $('#city option:selected').text('');
                        $('#district option[name="district"]').val('');
                        $('#district option:selected').text('');
                        $('#ward option[name="ward"]').val('');
                        $('#ward option:selected').text('');
                        $('#hs').empty();
                        $('#hs').append('<option value="0" selected>Chọn mã hồ sơ</option>');

                    }
                });
            });
        </script>


<script>
$(document).ready(function() {
    // Function to add row to the table
    function addRowToTable(type, result) {
        // Kiểm tra xem mã xét nghiệm đã tồn tại chưa
        var exists = false;
        $('#kqTable tbody tr').each(function() {
            var existingType = $(this).find('td').first().text();
            if (existingType.includes(type)) { // Kiểm tra nếu loại xét nghiệm đã tồn tại
                exists = true;
                return false; // Dừng vòng lặp
            }
        });

        if (!exists) {
            var row = `<tr>
                            <td>${type}</td>
                            <td>${result}</td>
                            <td><button class="btn btn-danger remove-row">Xóa</button></td>
                       </tr>`;
            $('#kqTable tbody').append(row);
        } else {
            alert('Loại xét nghiệm đã tồn tại.');
        }
    }

     // Khi submit form từ modal
     $('#addKqForm').on('submit', function(e) {
        e.preventDefault(); // Ngăn ngừa gửi form mặc định

        var xetnghiem_id = $('#modal_xetnghiem_id').val(); // Lấy giá trị Loại xét nghiệm
        var ket_qua = $('#modal_ket_qua').val(); // Lấy giá trị Kết quả

        // Đảm bảo hiển thị cả mã và tên xét nghiệm
        var tenxn = $('#modal_xetnghiem_id option:selected').text().split(' - ')[1]; // Tách tên xét nghiệm từ giá trị chọn
        var type = `${xetnghiem_id} - ${tenxn}`; // Kết hợp mã và tên xét nghiệm

        // Thêm vào bảng
        addRowToTable(type, ket_qua);

     

        // Đóng modal
        $('#addKqModal').modal('hide');
    });
    // Remove row
    $('#kqTable tbody').on('click', '.remove-row', function() {
        if (confirm('Bạn có chắc chắn muốn xóa dòng này không?')) {
            $(this).closest('tr').remove();
        }
    });
    // Khi chọn mã hồ sơ khác
    $('#hs').on('change', function() {
        // Xóa tất cả các hàng trong tbody
        $('#kqTable tbody').empty();
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Lấy các phần tử cần thiết
    const modalXetNghiemSelect = document.getElementById('modal_xetnghiem_id'); // Dropdown trong modal
    const modalKetQuaInput = document.getElementById('modal_ket_qua'); // Input Kết quả trong modal
    const hiddenXetNghiemInput = document.getElementById('xetnghiem_id_hidden'); // Input ẩn cho xetnghiem_id
    const hiddenKetQuaInput = document.getElementById('ketqua_hidden'); // Input ẩn cho kết quả
    const mainFormSaveButton = document.querySelector('form[action="{{ route('admin.add.kq.store') }}"] button[type="submit"]'); // Nút "Lưu" trong form chính

    // Khi nhấn nút Lưu của form chính
    if (mainFormSaveButton && modalXetNghiemSelect && hiddenXetNghiemInput && hiddenKetQuaInput) {
        mainFormSaveButton.addEventListener('click', function (e) {
            // Lấy giá trị từ dropdown và input trong modal
            const selectedXetNghiem = modalXetNghiemSelect.value;
            const ketQuaValue = modalKetQuaInput.value;

            // Kiểm tra nếu các giá trị không hợp lệ
            if (!selectedXetNghiem || selectedXetNghiem === "0") {
                e.preventDefault(); // Ngăn form gửi
                alert('Vui lòng chọn loại xét nghiệm trong modal trước khi lưu!');
                return;
            }

            if (!ketQuaValue || ketQuaValue.trim() === "") {
                e.preventDefault(); // Ngăn form gửi
                alert('Vui lòng nhập kết quả trong modal trước khi lưu!');
                return;
            }

            // Gán giá trị vào các input ẩn trong form chính
            hiddenXetNghiemInput.value = selectedXetNghiem;
            hiddenKetQuaInput.value = ketQuaValue;

            // Tiếp tục cho phép form gửi sau khi đã gán giá trị
        });
    }
});

</script>
<script>
    document.querySelector('form').addEventListener('submit', function(event) {
        var hs = document.getElementById('hs').value;
        if (hs === '0') {
            event.preventDefault();
            document.getElementById('error-message').style.display = 'block';
        } else {
            document.getElementById('error-message').style.display = 'none';
        }
    });
</script>

@endsection
