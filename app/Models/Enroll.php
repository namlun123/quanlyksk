<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Support\Facades\DB;

class Enroll extends Model
{
    use HasFactory;
    use Authenticatable;
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
        'result_pdf',
        'created_at',
        'updated_at',
        'updated_by_user',
        'updated_by_admin',
    ];
    public function patient()
    {
        return $this->belongsTo(Benhnhan::class, 'patient_id', 'id');
    }
    public function ketqua()
    {
        return $this->hasMany(KQ::class, 'hoso_id', 'id');
    }

}