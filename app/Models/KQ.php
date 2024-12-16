<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Support\Facades\DB;

class InfoAdmin extends Model implements AuthenticatableContract
{
    //
    use HasFactory;
    use Authenticatable;
    protected $table = 'ketqua';
}
