<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Announcement;
use App\Models\BookLoan;
use App\Models\ClassRoom;
use App\Models\Fee;
use App\Models\LibraryBook;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function stats(Request $request)
    {
        $schoolId = auth()->user()->school_id;

        $totalStudents = Student::where('school_id', $schoolId)->count();
        $totalTeachers = Teacher::where('school_id', $schoolId)->count();
        $totalClasses = ClassRoom::where('school_id', $schoolId)->count();

        $todayAttendance = Attendance::whereDate('date', today())
            ->whereHas('student', function ($q) use ($schoolId) {
                $q->where('school_id', $schoolId);
            })
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        $pendingFees = Fee::where('school_id', $schoolId)
            ->where('status', 'pending')
            ->sum('amount');

        $libraryBooks = LibraryBook::where('school_id', $schoolId)->sum('total_copies');
        $booksOut = BookLoan::whereHas('student', function ($q) use ($schoolId) {
            $q->where('school_id', $schoolId);
        })->where('status', 'borrowed')->count();

        $recentAnnouncements = Announcement::where('school_id', $schoolId)
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'total_students' => $totalStudents,
                'total_teachers' => $totalTeachers,
                'total_classes' => $totalClasses,
                'today_attendance' => $todayAttendance,
                'pending_fees' => $pendingFees,
                'library_books' => $libraryBooks,
                'books_out' => $booksOut,
                'recent_announcements' => $recentAnnouncements,
            ],
        ]);
    }

    public function attendanceChart(Request $request)
    {
        $schoolId = auth()->user()->school_id;

        $data = Attendance::whereHas('student', function ($q) use ($schoolId) {
                $q->where('school_id', $schoolId);
            })
            ->where('date', '>=', now()->subDays(30))
            ->select(
                'date',
                DB::raw('SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present'),
                DB::raw('SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'labels' => $data->pluck('date'),
                'datasets' => [
                    ['label' => 'Present', 'data' => $data->pluck('present')],
                    ['label' => 'Absent', 'data' => $data->pluck('absent')],
                ],
            ],
        ]);
    }

    public function financialChart(Request $request)
    {
        $schoolId = auth()->user()->school_id;

        $billed = Fee::where('school_id', $schoolId)
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $collected = Payment::whereHas('fee', function ($q) use ($schoolId) {
                $q->where('school_id', $schoolId);
            })
            ->where('status', 'completed')
            ->select(
                DB::raw('DATE_FORMAT(paid_at, "%Y-%m") as month'),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'labels' => $billed->pluck('month'),
                'datasets' => [
                    ['label' => 'Billed', 'data' => $billed->pluck('total')],
                    ['label' => 'Collected', 'data' => $collected->pluck('total')],
                ],
            ],
        ]);
    }
}
