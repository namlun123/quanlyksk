<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    // Xác định bảng trong database
    protected $table = 'locations';

    // Xác định khóa chính của bảng (nếu không phải 'id')
    protected $primaryKey = 'location_id';  // Thay đổi khóa chính nếu cần

    // Các trường có thể được gán giá trị mass assignment
    protected $fillable = [
        'location_name',
        'location_address',
        'created_by',
        'updated_by'
    ];

    // Các trường cần được tự động quản lý
    public $timestamps = true; // Laravel sẽ tự động cập nhật created_at và updated_at
}
