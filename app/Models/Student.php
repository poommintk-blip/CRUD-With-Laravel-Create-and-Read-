<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Student extends Model
{
//
use HasFactory;
// เพิ่มบรรทัดนี้ลงไปครับ เพื่ออนุญาตให้บันทึกข้อมูล 3 ช่องนี้ได้
protected $fillable = [
'student_code',
'name',
'department_id'
];
}
