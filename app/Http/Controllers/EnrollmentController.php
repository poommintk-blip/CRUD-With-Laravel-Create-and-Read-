<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EnrollmentDetail; 
use App\Models\Enrollment;       
use App\Models\Student;
use App\Models\Course;
use App\Models\Department;
use Exception;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        try {
            // เริ่มต้น Query จาก View
            $query = EnrollmentDetail::query();

            // 2. ถ้ามีการส่งค่า 'search' มา
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;

                // ค้นหาจากหลายคอลัมน์
                $query->where(function($q) use ($search) {
                    $q->where('student_name', 'LIKE', "%{$search}%")
                    ->orWhere('student_code', 'LIKE', "%{$search}%")
                    ->orWhere('course_name', 'LIKE', "%{$search}%")
                    ->orWhere('course_code', 'LIKE', "%{$search}%");
                });
            }

            // สั่งดึงข้อมูล
            $enrollments = $query->get();
            $students = Student::all();
            $courses = Course::all();
            $departments = Department::all();

            return view('enrollments.index', compact(
                'enrollments', 
                'students', 
                'courses', 
                'departments'
            ));
        } catch (Exception $e) {
            // ถ้า Database มีปัญหา (เช่นลืมเปิด Laragon) จะดีดกลับหน้าเดิมพร้อมแจ้งเตือน
            return back()->withErrors(['error' => 'การเชื่อมต่อฐานข้อมูลขัดข้อง: ' . $e->getMessage()]);
        }
    }

    public function storeStudent(Request $request)
    {
        try {
            Student::create($request->validate([
                'student_code' => 'required|unique:students',
                'name' => 'required',
                'department_id' => 'required'
            ]));

            return back()->with('success', 'เพิ่มรายชื่อนักศึกษาใหม่เรียบร้อย');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'ไม่สามารถเพิ่มข้อมูลได้: ' . $e->getMessage()]);
        }
    }

    public function showStudent($id)
    {
        // ใช้ findOrFail กัน Error กรณีไม่พบ ID
        $student = Student::with('department')->findOrFail($id);

        // ดึงจาก View
        $history = EnrollmentDetail::where('student_id', $id)->get();

        // คำนวณหน่วยกิตรวม
        $totalCredits = $history->sum(function($row) {
            // ตรวจสอบคอลัมน์ credits ใน View ถ้าไม่มีให้คืนค่า 0
            return $row->credits ?? 0; 
        });

        return view('enrollments.student_detail', compact('student', 'history', 'totalCredits'));
    }

    public function store(Request $request)
    {
        try {
            Enrollment::create($request->validate([
                'student_id' => 'required',
                'course_id' => 'required',
                'grade' => 'nullable'
            ]));
            return back()->with('success', 'ลงทะเบียนเรียบร้อยแล้ว');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'ไม่สามารถลงทะเบียนได้: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // ใช้ findOrFail กันกรณีหา ID ไม่เจอตอนอัปเดต
            $enrollment = Enrollment::findOrFail($id);
            $enrollment->update($request->validate([
                'grade' => 'nullable|string|max:2'
            ]));
            return back()->with('success', 'อัปเดตเกรดเรียบร้อย');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'อัปเดตไม่สำเร็จ: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            // เปลี่ยนเป็น findOrFail เพื่อความปลอดภัย
            $enrollment = Enrollment::findOrFail($id);
            $enrollment->delete();
            return back()->with('success', 'ถอนรายวิชาเรียบร้อย');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'ไม่สามารถลบข้อมูลได้: ' . $e->getMessage()]);
        }
    }

    public function report(Request $request)
    {
        try {
            $courses = Course::all();
            $results = collect(); 
            $selectedCourse = null;

            if ($request->has('course_id')) {
                $courseId = $request->course_id;
                
                $results = EnrollmentDetail::where('course_id', $courseId)
                            ->orderBy('student_code')
                            ->get();

                $selectedCourse = Course::find($courseId);
            }

            return view('enrollments.report', compact('courses', 'results', 'selectedCourse'));
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'เกิดข้อผิดพลาดในการดึงรายงาน: ' . $e->getMessage()]);
        }
    }
}