<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF; // Facade của barryvdh/laravel-dompdf
use App\Models\Benhnhan;
use App\Models\Hosokham;
use App\Models\KQ;

class PDFController extends Controller
{
    public function downloadPDF($hoso_id)
    {
        // Lấy hồ sơ khám
        $hoso = Hosokham::findOrFail($hoso_id);

        // Lấy thông tin bệnh nhân từ hồ sơ khám
        $benhnhan = Benhnhan::findOrFail($hoso->ma_benhnhan);

        // Lấy danh sách kết quả xét nghiệm từ hồ sơ
        $ketquas = KQ::where('id', $hoso_id)->get();

        // Dữ liệu để truyền vào view
        $data = [
            'benhnhan' => $benhnhan,
            'hoso' => $hoso,
            'ketquas' => $ketquas,
        ];

        // Tạo file PDF từ view
        $pdf = PDF::loadView('pdf.hoso', $data);

        // Xuất file PDF để tải xuống
        return $pdf->download("Hoso_{$hoso_id}.pdf");
    }
}
