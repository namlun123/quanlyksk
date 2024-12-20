<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctors';  // Tên bảng trong cơ sở dữ liệu (nếu khác mặc định)

    // Các thuộc tính có thể gán giá trị (mass assignable)
    protected $fillable = ['HoTen', 'ChucVu', 'PhiCoBan', 'specialty_id', 'created_by', 'location_id'];


    // Tạo mối quan hệ với bảng Specialty
    public function specialty()
    {
        return $this->belongsTo(Chuyenkhoa::class, 'specialty_id');
    }

    // Tạo mối quan hệ với bảng Location (nếu có)
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
