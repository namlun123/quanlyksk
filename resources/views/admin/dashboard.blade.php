@extends("layouts.admin")

@section("content")
<!-- Filter Section -->
<div class="row">
    <div class="col-md-12">
        <form method="GET" action="{{ route('admin.dashboard') }}">
            <div class="form-group">
                <label for="start_date">Lọc theo khoảng thời gian:</label>
                <input type="date" name="start_date" id="start_date" value="{{ request()->get('start_date', now()->startOfMonth()->toDateString()) }}" class="form-control">
            </div>
            <div class="form-group">
                <label for="end_date">To:</label>
                <input type="date" name="end_date" id="end_date" value="{{ request()->get('end_date', now()->endOfMonth()->toDateString()) }}" class="form-control">
            </div>
            <div class="form-group">
                <label for="location_filter">Lọc theo chi nhánh:</label>
                <select name="location_id" id="location_filter" class="form-control">
                    <option value="">Select Location</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->location_id }}" {{ request()->get('location_id') == $location->location_id ? 'selected' : '' }}>
                            {{ $location->location_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary filter-btn">Lọc</button>
        </form>
    </div>
</div>

<!-- Statistics Section -->
<div class="row">
    <!-- Revenue by Location -->
    <div class="col-md-6">
        <div class="widget widget-shadow">
            <h4>Doanh thu theo chi nhánh đã lọc</h4>
            <div class="revenue-by-location">
                @if(request()->get('location_id'))
                    @php
                        $location = $revenueByLocation->firstWhere('location_id', request()->get('location_id'));
                    @endphp
                    <h5>{{ number_format($location->total_revenue_locations ?? 0) }} VND</h5>
                @else
                    <h5>{{ number_format($revenueByLocation->sum('total_revenue_locations')) }} VND</h5>
                @endif
            </div>
        </div>
    </div>

    <!-- Doanh thu theo chi nhánh -->
    <div class="col-md-12">
        <div class="widget widget-shadow">
            <h4>Doanh thu theo chi nhánh</h4>
            <div class="chart-widget">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Dữ liệu doanh thu theo chi nhánh từ controller
        var revenueData = @json($revenueByLocation_time);

        // Tạo mảng nhãn và dữ liệu doanh thu
        var labels = revenueData.map(function(location) {
            return location.location_name;  // Tên chi nhánh
        });

        var data = revenueData.map(function(location) {
            return location.total_revenue_locations;  // Giá trị doanh thu
        });

        // Lấy context của canvas để vẽ biểu đồ
        var ctx = document.getElementById('revenueChart').getContext('2d');

        // Tạo biểu đồ
        var revenueChart = new Chart(ctx, {
            type: 'bar',  // Biểu đồ cột
            data: {
                labels: labels,  // Nhãn cho trục x
                datasets: [{
                    label: 'Doanh thu (VND)',  // Tiêu đề của biểu đồ
                    data: data,  // Dữ liệu doanh thu
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',  // Màu sắc cột
                    borderColor: 'rgba(75, 192, 192, 1)',  // Màu sắc viền cột
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,  // Kích thước phản hồi với màn hình
                scales: {
                    y: {
                        beginAtZero: true,  // Bắt đầu từ 0 trên trục y
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString();  // Định dạng hiển thị số với dấu phân cách hàng nghìn
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.raw.toLocaleString() + ' VND';  // Hiển thị tooltip với dấu phân cách hàng nghìn
                            }
                        }
                    }
                }
            }
        });
    });
</script>

<style>
    canvas {
        max-height: 400px;
    }

    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
    }

    .container {
        margin-top: 20px;
    }

    .form-group label {
        font-weight: bold;
    }

    #start_date, #end_date, #location_filter {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border-radius: 6px;
        border: 1px solid #ddd;
        font-size: 16px;
    }

    #start_date:focus, #end_date:focus, #location_filter:focus {
        border-color: #007bff;
        outline: none;
    }

    .filter-btn {
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
    }

    .filter-btn:hover {
        background-color: #0056b3;
    }

    .widget {
        background-color: white;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .widget h4 {
        font-size: 18px;
        margin-bottom: 15px;
        color: #333;
    }

    .widget-shadow {
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    .revenue-by-location h5, .paid-people h5, .cancelled-people h5, .total-revenue h5 {
        font-size: 20px;
        font-weight: bold;
        color: #2d3b55;
    }

    .chart-widget h4 {
        font-size: 18px;
        color: #333;
    }

    @media (max-width: 767px) {
        .widget {
            margin-bottom: 15px;
        }
        .filter-btn {
            width: 100%;
        }
    }
</style>
