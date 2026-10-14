<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    StudentController,
    TeacherController,
    ClassController,
    SubjectController,
    AttendanceController,
    MarkController,
    FeeController,
    PaymentController,
    AnnouncementController,
    DashboardController,
    ReportController,
    LibraryController,
    UserController,
    SchoolController,
};

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {
    
    // Auth
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Students
    Route::apiResource('students', StudentController::class);
    
    // Teachers
    Route::apiResource('teachers', TeacherController::class);
    
    // Classes
    Route::apiResource('classes', ClassController::class);
    
    // Subjects
    Route::apiResource('subjects', SubjectController::class);
    
    // Attendance
    Route::apiResource('attendance', AttendanceController::class);
    
    // Marks
    Route::apiResource('marks', MarkController::class);
    
    // Fees
    Route::apiResource('fees', FeeController::class);
    
    // Payments
    Route::apiResource('payments', PaymentController::class);
    
    // Announcements
    Route::apiResource('announcements', AnnouncementController::class);
    
    // Reports
    Route::prefix('reports')->group(function () {
        Route::get('/dashboard', [ReportController::class, 'dashboard']);
        Route::get('/students', [ReportController::class, 'students']);
        Route::get('/fees', [ReportController::class, 'fees']);
    });
    
    // Library
    Route::prefix('library')->group(function () {
        Route::get('/books', [LibraryController::class, 'index']);
        Route::post('/books', [LibraryController::class, 'store']);
        Route::get('/books/{id}', [LibraryController::class, 'show']);
        Route::put('/books/{id}', [LibraryController::class, 'update']);
        Route::delete('/books/{id}', [LibraryController::class, 'destroy']);
        Route::get('/loans', [LibraryController::class, 'loans']);
        Route::post('/borrow', [LibraryController::class, 'borrow']);
        Route::post('/return/{id}', [LibraryController::class, 'returnBook']);
    });
    
    // Users (Admin only)
    Route::apiResource('users', UserController::class);
    
    // Schools
    Route::apiResource('schools', SchoolController::class);
});
