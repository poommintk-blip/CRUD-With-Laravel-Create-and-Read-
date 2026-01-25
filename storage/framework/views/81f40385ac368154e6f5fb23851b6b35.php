<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบลงทะเบียนเรียน (Database Project)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light" style="background-image: url('<?php echo e(asset('images/bg.png')); ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;">

    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-8">
                <!-- ข้อความหัวข้อ -->
                <h2 class="text-primary text-muted"><i class="fas fa-university"></i> ระบบลงทะเบียนเรียน</h2>
                <p class="text-muted">ตัวอย่างการใช้ SQL View ร่วมกับ Laravel</p>

                <!-- ปุ่มรายงาน ให้เพิ่มอาทิตย์ถัดไป -->
                <a href="<?php echo e(route('report.index')); ?>" class="btn btn-sm btn-info text-white">
                    <i class="fas fa-file-alt"></i> รายงานตวามรายวิชา
                </a>
                <!-- สิ้นสุดปุ่มรายงาน -->

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
        <!-- ฟอร์มค้นหา -->
                <div class="row mb-3">
                    <div class="col-md-6 ms-auto">
                        <form action="<?php echo e(route('enrollments.index')); ?>" method="GET">
                            <div class="input-group">
                            <input type="text"
                                    name="search"
                                    class="form-control"
                                    placeholder= "ค้นหาชื่อ, รหัส, หรือวิชา..."
                                    value="<?php echo e(request('search')); ?>"> <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i> ค้นหา
                                </button>
                                <?php if(request('search')): ?>
                            <a href="<?php echo e(route('enrollments.index')); ?>" class="btn btn-secondary">
                            ล้างค่า
                            </a>
                                <?php endif; ?>
                           </div>
                       </form>
                    </div>
                </div>

        <!-- แสดงข้อความสถานะ -->
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

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
                        <?php $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <!-- ID -->
                            <td><span class="badge bg-secondary"><?php echo e($row->student_code); ?></span></td>
                            <!-- ลิงก์ไปยังหน้ารายละเอียดนักศึกษา -->
                            <td>
                                <!-- ชื่อนักศึกษาไปที่หน้า details ได้ ในอาทิตย์หน้า -->
                                <a href="<?php echo e(route('students.show', $row->student_id)); ?>" class="text-decoration-none fw-bold">
                                    <?php echo e($row->student_name); ?> <i class="fas fa-external-link-alt fa-xs text-muted"></i>
                                </a>
                            </td>
                            <!-- คณะ -->
                            <td><small class="text-muted"><?php echo e($row->department_name); ?></small></td>
                            <!-- ข้อมูลวิชา -->
                            <td>
                                <strong><?php echo e($row->course_code); ?></strong><br>
                                <?php echo e($row->course_name); ?>

                            </td>
                            <!-- ชื่ออาจารย์ผู้สอน -->
                            <td><?php echo e($row->instructor_name); ?></td>
                            <!-- เกรด -->
                            <td>
                                <?php if($row->grade): ?>
                                    <span class="badge bg-primary"><?php echo e($row->grade); ?></span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">รอเกรด</span>
                                <?php endif; ?>
                            </td>
                            <!-- ปุ่มจัดการ -->
                            <td class="text-center">
                                <!-- ปุ่มแก้ไขเกรด ให้เพิ่มอาทิตย์ถัดไป -->
                                <button class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal<?php echo e($row->enrollment_id); ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                                <!-- สิ้นสุดปุ่มแก้ไขเกรด -->
                                <!-- ฟอร์มลบการลงทะเบียน ให้เพิ่มอาทิตย์ถัดไป -->
                                <form action="<?php echo e(route('enrollments.destroy', $row->enrollment_id)); ?>" method="POST" class="d-inline"
                                      onsubmit="return confirm('ยืนยันการลบการลงทะเบียนนี้?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                <!-- สิ้นสุดฟอร์มลบการลงทะเบียน -->
                            </td>
                            <!-- สิ้นสุดปุ่มจัดการ -->
                        </tr>

                        <!-- โมดัลแก้ไขเกรด ให้เพิ่มอาทิตย์ถัดไป -->
                        <div class="modal fade" id="editModal<?php echo e($row->enrollment_id); ?>" tabindex="-1">
                        <div class="modal-dialog">
                        <div class="modal-content">
                        <form action="<?php echo e(route('enrollments.update', $row->enrollment_id)); ?>" method="POST">
                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                        <div class="modal-header">
                            <h5 class="modal-title">บันทึกเกรด: <?php echo e($row->student_name); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                <div class="modal-body">
            <label>วิชา: <?php echo e($row->course_code); ?> <?php echo e($row->course_name); ?></label>
                    <div class="mt-2">
                    <label class="form-label">เลือกเกรด</label>
                <select name="grade" class="form-select">
<option value="">-- รอตัดเกรด --</option>
<?php $__currentLoopData = ['A', 'B+', 'B', 'C+', 'C', 'D', 'F']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($g); ?>" <?php echo e($row->grade == $g ? 'selected' : ''); ?>><?php echo e($g); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    </div>
                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">บันทึก</button>
</div>
</form>
</div>
</div>
</div>
                        <!-- สิ้นสุดโมดัลแก้ไขเกรด -->
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- โมดัลเพิ่มการลงทะเบียนใหม่ -->
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?php echo e(route('enrollments.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-header">
                        <h5 class="modal-title">ลงทะเบียนรายวิชาใหม่</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">นักศึกษา</label>
                            <select name="student_id" class="form-select" required>
                                <option value="">-- เลือกนักศึกษา --</option>
                                <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($s->id); ?>"><?php echo e($s->student_code); ?> - <?php echo e($s->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">วิชาที่ลงทะเบียน</label>
                            <select name="course_id" class="form-select" required>
                                <option value="">-- เลือกวิชา --</option>
                                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($c->id); ?>"><?php echo e($c->code); ?> - <?php echo e($c->name); ?> (<?php echo e($c->credits); ?> หน่วยกิต)</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
            <form action="<?php echo e(route('students.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
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
                            <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($dept->id); ?>"><?php echo e($dept->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
    <!-- สิ้นสุดโมดัลเพิ่มฐานข้อมูลนักศึกษาใหม่ -->

</div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/MyB6803612CRUD/resources/views/enrollments/index.blade.php ENDPATH**/ ?>