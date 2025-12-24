<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบลงทะเบียนเรียน (Database Project)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light" style="background-image: url('{{ asset('Images/bg.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; min-height: 100vh;">

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <!-- ข้อความหัวข้อ -->
            <h2 class="text-primary text-muted"><i class="fas fa-university"></i> ระบบลงทะเบียนเรียน</h2>
            <p class="text-muted">ตัวอย่างการใช้ SQL View ร่วมกับ Laravel</p>

            <!-- ปุ่มรายงาน -->
            <!-- <a href="{{ route('enrollments.report') }}" class="btn btn-info">
                <i class="fas fa-chart-bar"></i> รายงาน
            </a> -->
        </div>
        <div class="col-md-4 text-end">
            <!-- ปุ่มเปิดโมดัลเพิ่มข้อมูล -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fas fa-plus"></i> ลงทะเบียนเพิ่ม
            </button>
            <!-- ปุ่มเปิดโมดัลเพิ่มนักศึกษาใหม่ -->
            <button type="button" class="btn btn-warning ms-2" data-bs-toggle="modal" data-bs-target="#createStudentModal">
                <i class="fas fa-user-plus"></i> เพิ่มนักศึกษาใหม่
            </button>
        </div>
    </div>

    <!-- แสดงข้อความสถานะ -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- ตารางแสดงข้อมูลการลงทะเบียน -->
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>รหัสนักศึกษา</th>
                        <th>ชื่อนักศึกษา</th>
                        <th>คณะ</th>
                        <th>วิชา</th>
                        <th>อาจารย์ผู้สอน</th>
                        <th>เกรด</th>
                        <th class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- รายการลงทะเบียน -->
                    @foreach($enrollments as $row)
                    <tr>
                        <!-- ID -->
                        <td><span class="badge bg-secondary">{{ $row->student_code }}</span></td>
                        <!-- ลิงก์ไปยังหน้ารายละเอียดนักศึกษา -->
                        <td>
                            <!-- ชื่อนักศึกษาไปที่หน้า details ได้ ในอาทิตย์หน้า -->
                            <a href="{{ route('students.show', $row->student_id) }}" class="text-decoration-none fw-bold">
                                {{ $row->student_name }} <i class="fas fa-external-link-alt fa-xs text-muted"></i>
                            </a>
                        </td>
                        <!-- คณะ -->
                        <td><small class="text-muted">{{ $row->department_name }}</small></td>
                        <!-- ข้อมูลวิชา -->
                        <td>
                            <strong>{{ $row->course_code }}</strong><br>
                            {{ $row->course_name }}
                        </td>
                        <!-- ชื่ออาจารย์ผู้สอน -->
                        <td>{{ $row->instructor_name }}</td>
                        <!-- เกรด -->
                        <td>
                            @if($row->grade)
                                <span class="badge bg-primary">{{ $row->grade }}</span>
                            @else
                                <span class="badge bg-warning text-dark">รอเกรด</span>
                            @endif
                        </td>
                        <!-- ปุ่มจัดการ -->
                        <td class="text-center">
                            <!-- ปุ่มแก้ไขเกรด -->
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editGradeModal{{ $row->enrollment_id }}">
                                <i class="fas fa-edit"></i>
                            </button>

                            <!-- ฟอร์มลบการลงทะเบียน -->
                            <form action="{{ route('enrollments.destroy', $row->enrollment_id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('ยืนยันการถอนวิชา?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                        <!-- สิ้นสุดปุ่มจัดการ -->
                    </tr>

                    <!-- โมดัลแก้ไขเกรด -->
                    <div class="modal fade" id="editGradeModal{{ $row->enrollment_id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('enrollments.update', $row->enrollment_id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">แก้ไขเกรด: {{ $row->student_name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">วิชา</label>
                                            <input type="text" class="form-control" value="{{ $row->course_code }} - {{ $row->course_name }}" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">เกรด</label>
                                            <select name="grade" class="form-select">
                                                <option value="">-- เลือกเกรด --</option>
                                                <option value="A" {{ $row->grade == 'A' ? 'selected' : '' }}>A</option>
                                                <option value="B+" {{ $row->grade == 'B+' ? 'selected' : '' }}>B+</option>
                                                <option value="B" {{ $row->grade == 'B' ? 'selected' : '' }}>B</option>
                                                <option value="C+" {{ $row->grade == 'C+' ? 'selected' : '' }}>C+</option>
                                                <option value="C" {{ $row->grade == 'C' ? 'selected' : '' }}>C</option>
                                                <option value="D+" {{ $row->grade == 'D+' ? 'selected' : '' }}>D+</option>
                                                <option value="D" {{ $row->grade == 'D' ? 'selected' : '' }}>D</option>
                                                <option value="F" {{ $row->grade == 'F' ? 'selected' : '' }}>F</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                        <button type="submit" class="btn btn-primary">บันทึก</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- สิ้นสุดโมดัลแก้ไขเกรด -->
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- โมดัลเพิ่มการลงทะเบียนใหม่ -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('enrollments.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">ลงทะเบียนรายวิชาใหม่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">นักศึกษา</label>
                        <select name="student_id" class="form-select" required>
                            <option value="">-- เลือกนักศึกษา --</option>
                            @foreach($students as $s)
                                <option value="{{ $s->id }}">{{ $s->student_code }} - {{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">วิชาที่ลงทะเบียน</label>
                        <select name="course_id" class="form-select" required>
                            <option value="">-- เลือกวิชา --</option>
                            @foreach($courses as $c)
                                <option value="{{ $c->id }}">{{ $c->code }} - {{ $c->name }} ({{ $c->credits }} หน่วยกิต)</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-success">ลงทะเบียน</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- สิ้นสุดโมดัลเพิ่มการลงทะเบียนใหม่ -->

<!-- โมดัลเพิ่มฐานข้อมูลนักศึกษาใหม่ -->
<div class="modal fade" id="createStudentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('students.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">เพิ่มฐานข้อมูลนักศึกษา</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">รหัสนักศึกษา</label>
                        <input type="text" name="student_code" class="form-control" required placeholder="เช่น 661234">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ชื่อ-นามสกุล</label>
                        <input type="text" name="name" class="form-control" required placeholder="เช่น นายรักเรียน เพียรศึกษา">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">สังกัดคณะ</label>
                        <select name="department_id" class="form-select" required>
                            <option value="">-- เลือกคณะ --</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- สิ้นสุดโมดัลเพิ่มฐานข้อมูลนักศึกษาใหม่ -->

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>