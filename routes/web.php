<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnrollmentController;

Route::resource('enrollments', EnrollmentController::class);
Route::get('/', [EnrollmentController::class, 'index']);
Route::post('/students', [EnrollmentController::class, 'storeStudent'])->name('students.store');
Route::get('/students/{id}', [EnrollmentController::class, 'showStudent'])->name('students.show');
Route::get('/report', [EnrollmentController::class, 'report'])->name('enrollments.report');
//รอเพิ่ม route details
//รอเพิ่ม route report
