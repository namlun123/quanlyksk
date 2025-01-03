<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Support\Facades\DB;

class Benhnhan extends Model implements AuthenticatableContract
{
    use HasFactory;
    use Authenticatable;
    protected $table = 'info_patients';
    public function taiKhoan()
    {
        return $this->belongsTo(TKbenhnhan::class, 'user_id', 'id');
    }
    public function enrolls()
    {
        return $this->hasMany(Enroll::class, 'patient_id', 'id');
    }
    
}
