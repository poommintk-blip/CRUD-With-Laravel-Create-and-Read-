<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\EnrollmentDetail; 
use App\Models\Enrollment;       
use App\Models\Student;
use App\Models\Course;
use App\Models\Department;

class EnrollmentController extends Controller
{
    //
    public function index()
    {
        $enrollments = EnrollmentDetail::all();
        $students = Student::all();
        $courses = Course::all();
        $departments = Department::all(); // <--- 1. เพิ่มบรรทัดนี้

        // ส่ง $departments ไปด้วย
        return view('enrollments.index', 
        compact('enrollments', 
        'students', 
        'courses', 
        'departments'));
    }

    public function storeStudent(Request $request)
    {
        // บันทึกลงตาราง students
        Student::create($request->validate([
            'student_code' => 'required|unique:students',
            'name' => 'required',
            'department_id' => 'required'
        ]));

        return back()->with('success', 'เพิ่มรายชื่อนักศึกษาใหม่เรียบร้อย');
    }

    public function showStudent($id)
    {
        // 1. Master Data: ข้อมูลนักศึกษา + คณะ
        $student = Student::with('department')->findOrFail($id);

        // 2. Details Data: ดึงจาก View ที่เราทำไว้ (Where ตาม student_id)
        $history = EnrollmentDetail::where('student_id', $id)->get();

        // 3. คำนวณหน่วยกิตรวม (ลูกเล่นเพิ่มเติม)
        $totalCredits = $history->sum(function($row) {
            // (ต้องดึง credit จาก Course จริง หรือจะ Join มาใน View ก็ได้)
            // เพื่อความง่ายในตัวอย่างนี้ ผมขอข้ามการดึง Credit ไปก่อน หรือ
            // ถ้าใน View ยังไม่มี credit ให้กลับไปแก้ View เพิ่ม column c.credits ก็ได้ครับ
            return 0; 
        });

        return view('enrollments.student_detail', compact('student', 'history'));
    }

    public function store(Request $request)
    {
        // บันทึกข้อมูลลง Table จริง
        Enrollment::create($request->validate([
            'student_id' => 'required',
            'course_id' => 'required',
            'grade' => 'nullable'
        ]));
        return back()->with('success', 'ลงทะเบียนเรียบร้อยแล้ว');
    }

    public function update(Request $request, $id)
    {
        // อัปเดตเกรด
        $enrollment = Enrollment::find($id);
        $enrollment->update(['grade' => $request->grade]);
        return back()->with('success', 'อัปเดตเกรดเรียบร้อย');
    }

    public function destroy($id)
    {
        // ลบข้อมูล
        Enrollment::destroy($id);
        return back()->with('success', 'ถอนรายวิชาเรียบร้อย');
    }

    // เพิ่มฟังก์ชันนี้ต่อท้ายสุดใน Controller
    public function report(Request $request)
    {
        // 1. ดึงรายชื่อวิชาทั้งหมด เพื่อเอาไปใส่ใน Dropdown ตัวเลือก
        $courses = Course::all();

        // 2. ตัวแปรเก็บผลลัพธ์ (เริ่มต้นเป็นค่าว่าง)
        $results = collect(); 
        $selectedCourse = null;

        // 3. ถ้ามีการเลือกวิชามา (กดปุ่มค้นหา)
        if ($request->has('course_id')) {
            $courseId = $request->course_id;
            
            // ดึงข้อมูลจาก View โดย Filter ตาม Course ID
            $results = EnrollmentDetail::where('course_id', $courseId)
                        ->orderBy('student_code') // เรียงตามรหัสนักศึกษา
                        ->get();

            // ดึงข้อมูลวิชาที่เลือกมาโชว์หัวกระดาษ
            $selectedCourse = Course::find($courseId);
        }

        return view('enrollments.report', 
        compact('courses', 'results', 'selectedCourse'));
    }
}