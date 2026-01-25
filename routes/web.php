<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnrollmentController;

Route::resource('enrollments', EnrollmentController::class);
Route::get('/', [EnrollmentController::class, 'index']);
Route::post('/students', [EnrollmentController::class, 'storeStudent'])->name('students.store');
//รอเพิ่ม route details
Route::get('/students/{id}/details', [EnrollmentController::class,'showStudent'])->name('students.show');
//รอเพิ่ม route report
Route::get('/reports', [EnrollmentController::class,'report'])->name('report.index');
