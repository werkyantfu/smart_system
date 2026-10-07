<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Fee;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function enrollment(Request $request)
    {
        $schoolId = auth()->user()->school_id;

        $total = Student::where('school_id', $schoolId)->count();
        
        $byGender = Student::where('school_id', $schoolId)
            ->select('gender', DB::raw('COUNT(*) as count'))
            ->groupBy('gender')
            ->get();

        $byGrade = Student::where('school_id', $schoolId)
            ->select('grade_level', DB::raw('COUNT(*) as count'))
            ->groupBy('grade_level')
            ->orderBy('grade_level')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'total_students' => $total,
                'by_gender' => $byGender,
                'by_grade' => $byGrade,
            ],
        ]);
    }

    public function financial(Request $request)
    {
        $schoolId = auth()->user()->school_id;

        $totalBilled = Fee::where('school_id', $schoolId)->sum('amount');
        $totalCollected = Payment::whereHas('fee', function ($q) use ($schoolId) {
            $q->where('school_id', $schoolId);
        })->where('status', 'completed')->sum('amount');

        $byMethod = Payment::whereHas('fee', function ($q) use ($schoolId) {
            $q->where('school_id', $schoolId);
        })
        ->where('status', 'completed')
        ->select('payment_method', DB::raw('SUM(amount) as total'))
        ->groupBy('payment_method')
        ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'total_billed' => $totalBilled,
                'total_collected' => $totalCollected,
                'total_outstanding' => $totalBilled - $totalCollected,
                'by_method' => $byMethod,
            ],
        ]);
    }

    public function attendance(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
        ]);

        $data = Attendance::where('class_id', $validated['class_id'])
            ->whereBetween('date', [$validated['from'], $validated['to']])
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'period' => $validated['from'] . ' to ' . $validated['to'],
                'summary' => $data,
            ],
        ]);
    }
}
