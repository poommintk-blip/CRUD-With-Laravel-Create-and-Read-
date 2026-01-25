<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE OR REPLACE VIEW enrollment_details AS
            SELECT
                e.id AS enrollment_id,
                s.student_code,
                s.name AS student_name,
                d.name AS department_name,
                c.code AS course_code,
                c.name AS course_name,
                i.name AS instructor_name,
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
};
