@extends('layout')
@section('content')
<style>
  .doctor-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    background-color: #f9f9f9;
    margin-bottom: 20px;
    transition: background-color 0.3s ease, transform 0.3s ease;
  }
  
  .doctor-card:hover {
    background-color: #e8f5e9;
    transform: scale(1.05);
  }
  
  .doctor-card img {
    max-width: 100%;
    height: auto;
    border-radius: 50%;
    max-height: 150px;
    object-fit: cover;
    margin-bottom: 15px;
  }
  
  .doctor-card h5 {
    font-size: 18px;
    font-weight: bold;
    color: #333;
  }
  
  .doctor-card p {
    font-size: 14px;
    color: #555;
  }
  
  .doctor-list {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: space-between;
  }
</style>

<div class="container mt-5">
  <!-- Title Section -->
  <div class="text-center mb-4">
    <h2 class="fw-bold text-dark">Đội ngũ Bác sĩ</h2>
    <p class="lead">Chúng tôi tự hào với đội ngũ bác sĩ giàu kinh nghiệm và tâm huyết.</p>
  </div>

  <!-- Doctor List Section -->
  <div class="doctor-list">
    @foreach($doctors as $doctor)
      <div class="col-md-4">
        <div class="doctor-card">
          <img src="{{ asset('public/frontend/images/'.$doctor->image) }}" alt="{{ $doctor->name }}">
          <h5>{{ $doctor->name }}</h5>
          <p><strong>Chuyên môn:</strong> {{ $doctor->specialization }}</p>
          <p>{{ Str::limit($doctor->description, 100) }}</p>
          <a href="{{ route('doctor.details', ['id' => $doctor->id]) }}" class="btn btn-success">Xem chi tiết</a>
        </div>
      </div>
    @endforeach
  </div>
</div>

@endsection
