<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cakham extends Model
{
    use HasFactory;
    use Authenticatable;
    protected $table = 'cakham';
}
