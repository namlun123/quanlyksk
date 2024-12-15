@extends("layouts.admin")
@section("content")
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="row-span-full" style="display: inline-block;" >
    <!-- @php
        $all_bn = DB::table('info_patients')->get();
        $doanhThu = DB::table('tbl_lich_thi AS lt')
    ->join('tbl_bai_thi AS bt', 'lt.baithi_id', '=', 'bt.baithi_id')
    ->select(DB::raw('SUM(lt.soluongdadangky * bt.baithi_lephi) AS totalRevenue'))
    ->first();
        $totalRevenue = $doanhThu->totalRevenue;
        $enrollsCount = DB::table('enrolls')->count('id');
        $enrollsCountNotPay = DB::table('enrolls')->where('trangthai', 0)->count('id');
        $enrollsCountPay = DB::table('enrolls')->where('trangthai', 1)->count('id');
        $lichthiactive = DB::table('tbl_lich_thi')->where('trangthai', 1)->count('lichthi_id');
 @endphp -->
    <div class="tile_count">
      <div class="col-md-4 col-sm-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Tổng số thí sinh</span>
        <!-- <div class="count">{{$all_ts->count()}}</div> -->
      </div>
      <div class="col-md-4 col-sm-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-money"></i> Tổng doanh thu</span>
        <!-- <div class="count">{{number_format($totalRevenue)}}</div> -->
      </div>
      <div class="col-md-4 col-sm-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Tổng số đăng ký</span>
        <!-- <div class="count green">{{$enrollsCount}}</div> -->
      </div>
      <div class="col-md-4 col-sm-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Tổng bài thi chưa thanh toán</span>
        <!-- <div class="count">{{$enrollsCountNotPay}}</div> -->
      </div>
      <div class="col-md-4 col-sm-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Tổng bài thi đã thanh toán</span>
        <!-- <div class="count blue">{{$enrollsCountPay}}</div> -->
      </div>
      <div class="col-md-4 col-sm-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-calendar"></i> Tổng lịch thi đang mở</span>
        <!-- <div class="count">{{$lichthiactive}}</div> -->
      </div>
    </div>
    <div class="tile_count">
        <canvas id="myChart" width="400" height="400"></canvas>
    </div>
  </div>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($dates) !!},
                datasets: [{
                    label: 'Số lượng đăng ký',
                    data: {!! json_encode($registrations) !!}
                }, {
                    label: 'Doanh thu',
                    data: {!! json_encode($revenues) !!}
                }, {
                    label: 'Số lượng chưa thanh toán',
                    data: {!! json_encode($unpaid) !!}
                }, {
                    label: 'Số lượng đã thanh toán',
                    data: {!! json_encode($paid) !!}
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
    @endsection
