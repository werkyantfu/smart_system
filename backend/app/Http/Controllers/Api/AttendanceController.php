<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with(['student', 'classRoom']);

        if ($request->class_id) {
            $query->where('class_id', $request->class_id);
        }
        if ($request->date) {
            $query->where('date', $request->date);
        }
        if ($request->student_id) {
            $query->where('student_id', $request->student_id);
        }

        $attendance = $query->paginate($request->per_page ?? 50);

        return response()->json([
            'success' => true,
            'data' => $attendance,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'date' => 'required|date',
            'records' => 'required|array|min:1',
            'records.*.student_id' => 'required|exists:students,id',
            'records.*.status' => 'required|in:present,absent,late,excused',
            'records.*.remarks' => 'nullable|string',
        ]);

        $saved = DB::transaction(function () use ($validated) {
            $count = 0;
            foreach ($validated['records'] as $record) {
                Attendance::updateOrCreate(
                    [
                        'student_id' => $record['student_id'],
                        'class_id' => $validated['class_id'],
                        'date' => $validated['date'],
                    ],
                    [
                        'status' => $record['status'],
                        'remarks' => $record['remarks'] ?? null,
                    ]
                );
                $count++;
            }
            return $count;
        });

        return response()->json([
            'success' => true,
            'message' => "Attendance marked for {$saved} students",
            'data' => ['saved' => $saved],
        ], 201);
    }

    public function summary(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'month' => 'nullable|date_format:Y-m',
        ]);

        $month = $validated['month'] ?? date('Y-m');

        $summary = Attendance::where('class_id', $validated['class_id'])
            ->whereYear('date', substr($month, 0, 4))
            ->whereMonth('date', substr($month, 5, 2))
            ->select('student_id',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present'),
                DB::raw('SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent'),
                DB::raw('SUM(CASE WHEN status = "late" THEN 1 ELSE 0 END) as late')
            )
            ->groupBy('student_id')
            ->with('student')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'month' => $month,
                'summary' => $summary,
            ],
        ]);
    }
}
