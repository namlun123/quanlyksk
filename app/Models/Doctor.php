<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctors'; // Tên bảng
    protected $fillable = ['HoTen', 'ChucVu', 'PhiCoBan', 'specialty_id', 'location_id'];

    // Mối quan hệ với bảng chuyên khoa (specialties)
    public function Chuyenkhoa()
    {
        return $this->belongsTo(Chuyenkhoa::class, 'specialty_id', 'specialty_id');
    }

    // Mối quan hệ với bảng địa điểm (locations)
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'location_id');
    }
}

