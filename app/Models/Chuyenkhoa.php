<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
class Chuyenkhoa extends Model
{
    use HasFactory;
    use Authenticatable;
    protected $table = 'specialties';
    protected $primaryKey = 'specialty_id';  // Khóa chính của bảng
    protected $fillable = ['specialty','mota'];
}
