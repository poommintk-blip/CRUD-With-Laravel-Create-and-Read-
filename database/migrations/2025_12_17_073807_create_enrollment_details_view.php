<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // วางทับได้เลย ตั้งแต่บรรทัดนี้ลงไป
public function up(): void
{
DB::statement("
CREATE OR REPLACE VIEW enrollment_details AS
SELECT
e.id as enrollment_id,
s.student_code,
s.name as student_name,
d.name as department_name,
c.code as course_code,
c.name as course_name,
i.name as instructor_name,
e.grade,
e.student_id,
e.course_id,
e.created_at
FROM enrollments e
JOIN students s ON e.student_id = s.id
JOIN departments d ON s.department_id = d.id
JOIN courses c ON e.course_id = c.id
JOIN instructors i ON c.instructor_id = i.id
");
}
/**
* Reverse the migrations.
*/
public function down(): void
{
DB::statement("DROP VIEW IF EXISTS enrollment_details");
}
// สิ้นสุดการวางทับ
};
