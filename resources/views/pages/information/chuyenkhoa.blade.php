@extends('layout')
@section('content')
<style>
  .btn-link.text-dark {
    color: black !important; /* Ghi đè màu mặc định */
    text-decoration: none;   /* Loại bỏ gạch chân nếu cần */
  }
  .btn-link.text-dark:hover {
    color: #333; /* Màu khi hover */
  }
  .faq-table {
  margin-top: 30px; /* Điều chỉnh khoảng cách theo ý muốn */
}
.row .col-md-6 {
  margin-bottom: 30px; /* Điều chỉnh khoảng cách theo ý muốn */
}
/* Khung tin tức */
/* Khung tin tức */
.list-group-item {
  border: 1px solid #ddd; /* Khung xung quanh mỗi mục */
  border-radius: 8px; /* Bo tròn các góc */
  padding: 15px; /* Khoảng cách bên trong mỗi mục */
  background-color: #f9f9f9; /* Màu nền sáng */
  transition: background-color 0.3s ease, transform 0.3s ease; /* Hiệu ứng khi di chuột */
  max-width: 320px; /* Giới hạn chiều rộng của mục tin tức */
  margin-bottom: 15px; /* Khoảng cách giữa các bài viết */
  margin-left: auto; /* Căn giữa các mục */
  margin-right: auto; /* Căn giữa các mục */
}

/* Thêm hiệu ứng hover */
.list-group-item:hover {
  background-color: #e8f5e9; /* Màu nền khi hover */
  transform: scale(1.05); /* Tạo hiệu ứng phóng to nhẹ khi hover */
}

/* Cải thiện ảnh trong tin tức */
.news-item img {
  max-width: 100%; /* Đảm bảo ảnh không vượt quá chiều rộng */
  height: auto; /* Giữ tỷ lệ của ảnh */
  max-height: 150px; /* Giới hạn chiều cao của ảnh */
  object-fit: cover; /* Đảm bảo ảnh không bị méo */
}

/* Tăng kích thước chữ tiêu đề */
.news-item h5 {
  font-size: 16px; /* Giảm kích thước chữ tiêu đề */
  font-weight: bold;
  margin-bottom: 10px; /* Khoảng cách dưới tiêu đề */
  color: #333; /* Màu chữ tiêu đề */
}

/* Định dạng đoạn mô tả */
.news-item p {
  font-size: 14px; /* Giảm kích thước chữ mô tả */
  color: #555;
  margin-bottom: 0; /* Loại bỏ khoảng cách dưới đoạn mô tả */
}


</style>
<div class="container mt-5">
  <!-- Title Section -->
  <div class="text-center mb-4">
    <h2 class="fw-bold text-dark">Bệnh viện Đa khoa Healthcare</h2>
    <p class="lead">Chăm sóc sức khỏe tận tâm - Nơi bạn đặt niềm tin</p>
  </div>

  <!-- Main Content Section -->
  <div class="row">
    <!-- Left Column -->
    <div class="col-md-8">
      <!-- Working Hours Section -->
      <div class="mb-5 mt-5"> <!-- Thêm margin-top để tạo khoảng cách -->
        <h3 class="text-secondary">Giờ làm việc</h3>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Thứ</th>
              <th>Thời gian</th>
              <th>Ngoài giờ</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Thứ Hai - Thứ Sáu</td>
              <td>8:00 - 17:00</td>
              <td>17:00 - 20:00</td>
            </tr>
            <tr>
              <td>Thứ Bảy</td>
              <td>8:00 - 17:00</td>
              <td>Nghỉ</td>
            </tr>
            <tr>
              <td>Chủ Nhật</td>
              <td>8:00 - 17:00</td>
              <td>Nghỉ</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Main Content Section -->
  <div class="row">
    <!-- Left Column -->
    <div class="col-md-8">
      <h3 class="text-secondary">Danh sách chuyên khoa</h3>
      
        
    
      </div>
    </div>

      <!-- FAQ Section -->
      <table class="table table-bordered faq-table">
        <thead>
          <tr>
            <th class="text-secondary">Câu hỏi thường gặp</th>
          </tr>
        </thead>
        <tbody id="faqTable">
          <tr>
            <td>
              <button class="btn btn-link text-dark w-100 text-left" type="button" data-toggle="collapse" data-target="#answerOne" aria-expanded="false" aria-controls="answerOne">
                <span class="mr-2">+</span> Câu hỏi 1: Thời gian khám bệnh như thế nào?
              </button>
              <div id="answerOne" class="collapse mt-2">
                Thời gian khám bệnh từ Thứ Hai đến Thứ Sáu, 8:00 - 17:00 và Thứ Bảy, 8:00 - 12:00.
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <button class="btn btn-link text-dark w-100 text-left" type="button" data-toggle="collapse" data-target="#answerTwo" aria-expanded="false" aria-controls="answerTwo">
                <span class="mr-2">+</span> Câu hỏi 2: Bệnh viện có các dịch vụ cấp cứu không?
              </button>
              <div id="answerTwo" class="collapse mt-2">
                Chúng tôi có dịch vụ cấp cứu 24/7 với đội ngũ bác sĩ chuyên nghiệp.
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <button class="btn btn-link text-dark w-100 text-left" type="button" data-toggle="collapse" data-target="#answerThree" aria-expanded="false" aria-controls="answerThree">
                <span class="mr-2">+</span> Câu hỏi 3: Tôi cần đặt lịch khám trước không?
              </button>
              <div id="answerThree" class="collapse mt-2">
                Chúng tôi khuyến khích đặt lịch trước để tránh thời gian chờ lâu.
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

<!-- Right Column: News Section -->
<div class="col-md-4">
  <h3 class="text-secondary">Tin tức</h3>
  <div class="list-group">
    <a href="#" class="list-group-item list-group-item-action">
      <div class="news-item">
        <h5 class="font-weight-bold">Bài viết 1: Tầm quan trọng của khám sức khỏe định kỳ</h5>
        <img src="{{ asset('public/frontend/images/hs1.jpg') }}" alt="Khám sức khỏe định kỳ" class="img-fluid mb-2">
        <p class="text-muted">Khám sức khỏe định kỳ rất quan trọng để phát hiện sớm các bệnh lý nguy hiểm...</p>
      </div>
    </a>
    <a href="#" class="list-group-item list-group-item-action">
      <div class="news-item">
        <h5 class="font-weight-bold">Bài viết 2: Cách phòng ngừa bệnh cúm mùa</h5>
        <img src="{{ asset('public/frontend/images/hs2.jpg') }}" alt="Phòng ngừa bệnh cúm mùa" class="img-fluid mb-2">
        <p class="text-muted">Bệnh cúm mùa có thể phòng ngừa hiệu quả nếu biết cách áp dụng các biện pháp...</p>
      </div>
    </a>
    <a href="#" class="list-group-item list-group-item-action">
      <div class="news-item">
        <h5 class="font-weight-bold">Bài viết 3: Những điều cần biết khi tiêm vắc xin</h5>
        <img src="{{ asset('public/frontend/images/hs3.jpg') }}" alt="Tiêm vắc xin" class="img-fluid mb-2">
        <p class="text-muted">Tiêm vắc xin giúp bảo vệ sức khỏe cộng đồng. Những thông tin cần biết trước khi tiêm...</p>
      </div>
    </a>
  </div>
</div>


@endsection
