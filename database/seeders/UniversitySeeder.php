<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Instructor;
use App\Models\Student;
use App\Models\Course;
class UniversitySeeder extends Seeder
{
/**
* Run the database seeds.
*/
public function run(): void
{
//
// 1. สร้างคณะ
$cs = Department::create(['name' => 'วิทยาการคอมพิวเตอร์']);
$it = Department::create(['name' => 'เทคโนโลยีสารสนเทศ']);
// 2. สร้างอาจารย์
$aj_a = Instructor::create(['name' => 'ดร.สมชาย ใจดี'
, 'department_id' => $cs->id]);
$aj_b = Instructor::create(['name' => 'อ.วิภา รักเรียน'
, 'department_id' => $it->id]);
// 3. สร้างนักศึกษา
Student::create(['student_code' => '66001', 'name' => '
'
นาย ก.
, 'department_id' =>
$cs->id]);
Student::create(['student_code' => '66002', 'name' => '
'
นางสาว ข.
,
'department_id' =>
$it->id]);
// 4. สร้างวิชา
Course::create(['code' => 'CS101', 'name' => 'เขียนโปรแกรมเบื้องต้น'
, 'instructor_id' =>
$aj_a->id, 'credits' => 3]);
Course::create(['code' => 'IT202', 'name' => 'ฐานข้อมูล'
,
'instructor_id' => $aj_b->id,
'credits' => 3]);
}
}
