<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrollmentDetail extends Model
{
    public $table = 'enrollment_details'; // ชี้ไปที่ View
public $timestamps = false; // View ไม่มี timestamp ของตัวเอง
// ใช้สําหรับ Read (R) เท่านั้น
}
