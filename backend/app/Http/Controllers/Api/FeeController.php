<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Fee::with(['student', 'payments']);

        if ($request->student_id) {
            $query->where('student_id', $request->student_id);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->fee_type) {
            $query->where('fee_type', $request->fee_type);
        }

        $fees = $query->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'data' => $fees,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'fee_type' => 'required|in:tuition,transport,cafeteria,library,uniform',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
        ]);

        $validated['school_id'] = auth()->user()->school_id;
        $validated['status'] = 'pending';

        $fee = Fee::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Fee created successfully',
            'data' => $fee,
        ], 201);
    }

    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'grade_level' => 'required|integer|between:1,12',
            'section' => 'nullable|string',
            'fee_type' => 'required|in:tuition,transport,cafeteria,library,uniform',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
        ]);

        $students = Student::where('school_id', auth()->user()->school_id)
            ->where('grade_level', $validated['grade_level'])
            ->when($validated['section'] ?? null, function ($q) use ($validated) {
                $q->where('section', $validated['section']);
            })
            ->get();

        $count = DB::transaction(function () use ($students, $validated) {
            $c = 0;
            foreach ($students as $student) {
                Fee::create([
                    'school_id' => auth()->user()->school_id,
                    'student_id' => $student->id,
                    'fee_type' => $validated['fee_type'],
                    'amount' => $validated['amount'],
                    'due_date' => $validated['due_date'],
                    'status' => 'pending',
                ]);
                $c++;
            }
            return $c;
        });

        return response()->json([
            'success' => true,
            'message' => "Fees created for {$count} students",
            'data' => [
                'created' => $count,
                'total_amount' => $count * $validated['amount'],
            ],
        ], 201);
    }

    public function show(Fee $fee)
    {
        $fee->load(['student', 'payments']);

        return response()->json([
            'success' => true,
            'data' => $fee,
        ]);
    }
}
