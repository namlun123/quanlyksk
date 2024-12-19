<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    public function enrollments()
    {
        return $this->hasMany(Enroll::class, 'doctor_id');
    }
}
