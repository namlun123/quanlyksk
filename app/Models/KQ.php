<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Support\Facades\DB;

class KQ extends Model implements AuthenticatableContract
{
    //
    use HasFactory;
    use Authenticatable;
    protected $table = 'ketqua';
    public function enroll()
    {
        return $this->belongsTo(Enroll::class, 'hoso_id', 'id');
    }
    public function loaixn()
    {
        return $this->belongsTo(LoaiXN::class, 'xn_id', 'xetnghiem_id');
    }
    
}
