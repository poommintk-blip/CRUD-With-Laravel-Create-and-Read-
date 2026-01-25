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
<body class="bg-light"style="background-image: url('{{ asset('Images/bg.png') }}');
background-size: cover; background-position: center;
background-repeat: no-repeat; background-attachment: fixed;
min-height: 100vh;">

<div class="container mt-4">
<div class="card mb-4 no-print">
<div class="card-body">
<form action="{{ route('report.index') }}" method="GET" class="row g-3 align-items-end">
<div class="col-md-4">
<label class="form-label">เลือกรายวิชาที่จะออกรายงาน</label>
<select name="course_id" class="form-select" required>
<option value="">-- เลือกรายวิชา --</option>
@foreach($courses as $c)
<option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>{{ $c->code }} - {{ $c->name }}
</option>
@endforeach
</select>
</div>
<div class="col-md-2">
<button type="submit" class="btn btn-primary w-100">
<i class="fas fa-search"></i> ค้นหา
</button>
</div>
<div class="col-md-2 ms-auto text-end">
<a href="{{ url('/') }}" class="btn btn-secondary">กลับหน้าหลัก</a>
</div>
</form>
</div>
</div>
@if(isset($selectedCourse))
<div class="card shadow-sm p-4" style="min-height: 800px;"> <div class="card-body">
<div class="text-center mb-4">
<h3 class="fw-bold">ใบรายชื่อนักศึกษา (Class Roster)</h3>
<p class="mb-0">มหาวิทยาลัยเทคโนโลยีจําลอง (Demo University)</p>
<hr>
</div>
<div class="row mb-4">
<div class="col-6">
<strong>รหัสวิชา:</strong> {{ $selectedCourse->code }}<br>
<strong>ชื่อวิชา:</strong> {{ $selectedCourse->name }}
</div>
<div class="col-6 text-end">
<strong>อาจารย์ผู้สอน:</strong> {{ $results->first()->instructor_name ?? 'ไม่ระบุ'
}}<br>
<strong>จํานวนนักศึกษา:</strong> {{ $results->count() }} คน
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
@forelse($results as $index => $row)
<tr>
<td class="text-center">{{ $index + 1 }}</td>
<td class="text-center">{{ $row->student_code }}</td>
<td>{{ $row->student_name }}</td>
<td>{{ $row->department_name }}</td>
</tr>
@empty
<tr>
<td colspan="4" class="text-center text-muted py-3">ไม่พบข้อมูลนักศึกษาในรายวิชา
นี้</td>
</tr>
@endforelse
</tbody>
</table>
<div class="mt-5 pt-5 text-end no-print">
<button onclick=
"window.print()" class="btn btn-success btn-lg">
<i class="fas fa-print"></i> พิมพ์รายงาน
</button>
</div>
<div class="mt-5 text-center text-muted small d-none d-print-block">
พิมพ์เมื่อ: {{ date('d/m/Y H:i') }}
</div>
</div>
</div>
@endif
</div>
</body>
</html>