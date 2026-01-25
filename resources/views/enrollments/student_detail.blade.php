<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัตินักศึกษา - {{ $student->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light" style="background-image: url('{{ asset('images/bg.png') }}');
            background-size: cover; 
            background-repeat: no-repeat; 
            background-attachment: fixed;">

<div class="container mt-5">
    <a href="{{ url('/') }}" class="btn btn-secondary mb-3">
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
                    <h4>{{ $student->name }}</h4>
                    <p class="text-muted mb-1">รหัส: {{ $student->student_code }}</p>
                    <span class="badge bg-info text-dark">{{ $student->department->name }}</span>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>วิชาที่ลงทะเบียน</span>
                        <strong>{{ $history->count() }} วิชา</strong>
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
                            @forelse($history as $row)
                            <tr>
                                <td>{{ $row->course_code }}</td>
                                <td>{{ $row->course_name }}</td>
                                <td><small class="text-muted">{{ $row->instructor_name }}</small></td>
                                <td class="text-center">
                                    @if($row->grade)
                                        <span class="badge bg-success">{{ $row->grade }}</span>
                                    @else
                                        <span class="badge bg-warning text-dark">รอเกรด</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    ยังไม่มีการลงทะเบียนเรียน
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>