<?php

namespace App\Models;

use App\Http\Middleware\Thisinh;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class TKbenhnhan extends Model implements AuthenticatableContract
{
    use HasFactory;
    use Authenticatable;

    // Điều chỉnh bảng tên để liên kết với bảng `patients`
    protected $table = 'patients';

    // Sửa lại mối quan hệ `benhNhan` để tham chiếu đến khóa chính `id` của bảng `patients`
    public function benhNhan()
    {
        return $this->hasOne(Benhnhan::class, 'user_id', 'id');
    }
}
