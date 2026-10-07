<?php

use App\Http\Controllers\Api\AnnouncementController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClassController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\FeeController;
use App\Http\Controllers\Api\MarkController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\SubjectController;
use App\Http\Controllers\Api\TeacherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ═══════════════════════════════════════
// PUBLIC ROUTES
// ═══════════════════════════════════════

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
});

// ═══════════════════════════════════════
// PROTECTED ROUTES
// ═══════════════════════════════════════

Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });

    // Students
    Route::apiResource('students', StudentController::class);

    // Teachers
    Route::apiResource('teachers', TeacherController::class);

    // Classes
    Route::apiResource('classes', ClassController::class);
    Route::get('classes/{class}/students', [ClassController::class, 'students']);

    // Subjects
    Route::apiResource('subjects', SubjectController::class);

    // Attendance
    Route::prefix('attendance')->group(function () {
        Route::get('/', [AttendanceController::class, 'index']);
        Route::post('/', [AttendanceController::class, 'store']);
        Route::get('summary', [AttendanceController::class, 'summary']);
    });

    // Marks
    Route::prefix('marks')->group(function () {
        Route::get('/', [MarkController::class, 'index']);
        Route::post('/', [MarkController::class, 'store']);
        Route::get('report-card/{student}', [MarkController::class, 'reportCard']);
    });

    // Fees
    Route::prefix('fees')->group(function () {
        Route::get('/', [FeeController::class, 'index']);
        Route::post('/', [FeeController::class, 'store']);
        Route::post('bulk', [FeeController::class, 'bulkStore']);
        Route::get('{fee}', [FeeController::class, 'show']);
    });

    // Payments
    Route::prefix('payments')->group(function () {
        Route::get('/', [PaymentController::class, 'index']);
        Route::post('/', [PaymentController::class, 'store']);
        Route::get('{payment}', [PaymentController::class, 'show']);
    });

    // Announcements
    Route::apiResource('announcements', AnnouncementController::class);

    // Reports
    Route::prefix('reports')->group(function () {
        Route::get('enrollment', [ReportController::class, 'enrollment']);
        Route::get('financial', [ReportController::class, 'financial']);
        Route::get('attendance', [ReportController::class, 'attendance']);
    });

    // Dashboard
    Route::prefix('dashboard')->group(function () {
        Route::get('stats', [DashboardController::class, 'stats']);
        Route::get('charts/attendance', [DashboardController::class, 'attendanceChart']);
        Route::get('charts/financial', [DashboardController::class, 'financialChart']);
    });
});

// ═══════════════════════════════════════
// FALLBACK ROUTE
// ═══════════════════════════════════════

Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'Route not found',
    ], 404);
});
