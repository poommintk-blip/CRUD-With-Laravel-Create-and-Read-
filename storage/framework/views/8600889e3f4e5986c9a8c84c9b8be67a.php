<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>รายงานรายชื่อผู้เข้าเรียน</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
/* ตั้งค่าสําหรับการสั่งปริ้น */
@media print {
.no-print { display: none !important; } /* ซ่อนปุ่มตอนปริ้น */
.card { border: none !important; box-shadow: none !important; }
}
</style>
</head>
<body class="bg-light"style="background-image: url('<?php echo e(asset('Images/bg.png')); ?>');
background-size: cover; background-position: center;
background-repeat: no-repeat; background-attachment: fixed;
min-height: 100vh;">

<div class="container mt-4">
<div class="card mb-4 no-print">
<div class="card-body">
<form action="<?php echo e(route('report.index')); ?>" method="GET" class="row g-3 align-items-end">
<div class="col-md-4">
<label class="form-label">เลือกรายวิชาที่จะออกรายงาน</label>
<select name="course_id" class="form-select" required>
<option value="">-- เลือกรายวิชา --</option>
<?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<option value="<?php echo e($c->id); ?>" <?php echo e(request('course_id') == $c->id ? 'selected' : ''); ?>><?php echo e($c->code); ?> - <?php echo e($c->name); ?>

</option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
</div>
<div class="col-md-2">
<button type="submit" class="btn btn-primary w-100">
<i class="fas fa-search"></i> ค้นหา
</button>
</div>
<div class="col-md-2 ms-auto text-end">
<a href="<?php echo e(url('/')); ?>" class="btn btn-secondary">กลับหน้าหลัก</a>
</div>
</form>
</div>
</div>
<?php if(isset($selectedCourse)): ?>
<div class="card shadow-sm p-4" style="min-height: 800px;"> <div class="card-body">
<div class="text-center mb-4">
<h3 class="fw-bold">ใบรายชื่อนักศึกษา (Class Roster)</h3>
<p class="mb-0">มหาวิทยาลัยเทคโนโลยีจําลอง (Demo University)</p>
<hr>
</div>
<div class="row mb-4">
<div class="col-6">
<strong>รหัสวิชา:</strong> <?php echo e($selectedCourse->code); ?><br>
<strong>ชื่อวิชา:</strong> <?php echo e($selectedCourse->name); ?>

</div>
<div class="col-6 text-end">
<strong>อาจารย์ผู้สอน:</strong> <?php echo e($results->first()->instructor_name ?? 'ไม่ระบุ'); ?><br>
<strong>จํานวนนักศึกษา:</strong> <?php echo e($results->count()); ?> คน
</div>
</div>
<table class="table table-bordered">
<thead class="table-light text-center">
<tr>
<th style="width: 10%">ลําดับ</th>
<th style="width: 20%">รหัสนักศึกษา</th>
<th style="width: 40%">ชื่อ-นามสกุล</th>
<th style="width: 30%">คณะ</th>
</tr>
</thead>
<tbody>
<?php $__empty_1 = true; $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<tr>
<td class="text-center"><?php echo e($index + 1); ?></td>
<td class="text-center"><?php echo e($row->student_code); ?></td>
<td><?php echo e($row->student_name); ?></td>
<td><?php echo e($row->department_name); ?></td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<tr>
<td colspan="4" class="text-center text-muted py-3">ไม่พบข้อมูลนักศึกษาในรายวิชา
นี้</td>
</tr>
<?php endif; ?>
</tbody>
</table>
<div class="mt-5 pt-5 text-end no-print">
<button onclick=
"window.print()" class="btn btn-success btn-lg">
<i class="fas fa-print"></i> พิมพ์รายงาน
</button>
</div>
<div class="mt-5 text-center text-muted small d-none d-print-block">
พิมพ์เมื่อ: <?php echo e(date('d/m/Y H:i')); ?>

</div>
</div>
</div>
<?php endif; ?>
</div>
</body>
</html><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/MyB6803612CRUD/resources/views/enrollments/report.blade.php ENDPATH**/ ?>