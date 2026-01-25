<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
// 1. ตาราง Departments (คณะ)
    Schema::create('departments', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->timestamps();
});
// 2. ตาราง Instructors (อาจารย์)
Schema::create('instructors', function (Blueprint $table) {
$table->id();
$table->string('name');
$table->foreignId('department_id')->constrained('departments');
$table->timestamps();
});
// 3. ตาราง Students (นักศึกษา)
Schema::create('students', function (Blueprint $table) {
$table->id();
$table->string('student_code');
$table->string('name');
$table->foreignId('department_id')->constrained('departments');
$table->timestamps();
});
// 4. ตาราง Courses (วิชา)
Schema::create('courses', function (Blueprint $table) {
$table->id();
$table->string('code');
$table->string('name');
$table->foreignId('instructor_id')->constrained('instructors');
$table->integer('credits');
$table->timestamps();
});
// 5. ตาราง Enrollments (การลงทะเบียน)
Schema::create('enrollments', function (Blueprint $table) {
$table->id();
$table->foreignId('student_id')->constrained('students')->onDelete('cascade');
$table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
$table->string('grade')->nullable();
$table->timestamps();
});
}

/**
 * Reverse the migrations.
 */
public function down(): void
{
Schema::dropIfExists('enrollments');
Schema::dropIfExists('courses');
Schema::dropIfExists('students');
Schema::dropIfExists('instructors');
Schema::dropIfExists('departments');
}
// สิ้นสุดการวางทับ
};
