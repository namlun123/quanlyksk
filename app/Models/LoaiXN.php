<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Support\Facades\DB;

class LoaiXN extends Model implements AuthenticatableContract
{
    //
    use HasFactory;
    use Authenticatable;
    protected $table = 'loaixn';
    public function ketqua()
    {
        return $this->hasMany(Ketqua::class, 'xn_id', 'xetnghiem_id');
    }

}

