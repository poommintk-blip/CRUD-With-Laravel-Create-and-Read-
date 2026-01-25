<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัตินักศึกษา - <?php echo e($student->name); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light" style="background-image: url('<?php echo e(asset('images/bg.png')); ?>');
            background-size: cover; 
            background-repeat: no-repeat; 
            background-attachment: fixed;">

<div class="container mt-5">
    <a href="<?php echo e(url('/')); ?>" class="btn btn-secondary mb-3">
        <i class="fas fa-arrow-left"></i> กลับหน้าหลัก
    </a>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="bg-primary text-white rounded-circle d-inline-flex justify-content-center align-items-center mb-3" 
                    style="width: 80px; height: 80px; font-size: 2rem;">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h4><?php echo e($student->name); ?></h4>
                    <p class="text-muted mb-1">รหัส: <?php echo e($student->student_code); ?></p>
                    <span class="badge bg-info text-dark"><?php echo e($student->department->name); ?></span>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>วิชาที่ลงทะเบียน</span>
                        <strong><?php echo e($history->count()); ?> วิชา</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>สถานะ</span>
                        <span class="text-success">กำลังศึกษา</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-book"></i> ประวัติการลงทะเบียนเรียน</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>รหัสวิชา</th>
                                <th>ชื่อวิชา</th>
                                <th>ผู้สอน</th>
                                <th class="text-center">เกรด</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($row->course_code); ?></td>
                                <td><?php echo e($row->course_name); ?></td>
                                <td><small class="text-muted"><?php echo e($row->instructor_name); ?></small></td>
                                <td class="text-center">
                                    <?php if($row->grade): ?>
                                        <span class="badge bg-success"><?php echo e($row->grade); ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">รอเกรด</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    ยังไม่มีการลงทะเบียนเรียน
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/MyB6803612CRUD/resources/views/enrollments/student_detail.blade.php ENDPATH**/ ?>