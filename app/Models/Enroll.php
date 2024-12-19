<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enroll extends Model
{
    protected $table = 'enrolls';  // Chỉ định tên bảng nếu tên bảng khác với tên model
    protected $primaryKey = 'id';
    protected $fillable = [
        'status',
        'total_cost',
        'date',
        'time_slot',
        'patient_id',
        'doctor_id',
        'specialty_id',
        'location_id',
        'reason',
        'ketqua_id',
        'created_at',
    ];
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');  // 'doctor_id' là khóa ngoại trong bảng enrolls
    }
    public function patients()
    {
        return $this->belongsTo(Benhnhan::class, 'patient_id'); // 'patient_id' là trường trong bảng enroll
    }
    public function locations()
    {
        return $this->belongsTo(Benhnhan::class, 'location_id'); // 'patient_id' là trường trong bảng enroll
    }
}