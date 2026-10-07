<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mark;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarkController extends Controller
{
    public function index(Request $request)
    {
        $query = Mark::with(['student', 'subject', 'exam']);

        if ($request->student_id) {
            $query->where('student_id', $request->student_id);
        }
        if ($request->subject_id) {
            $query->where('subject_id', $request->subject_id);
        }
        if ($request->exam_id) {
            $query->where('exam_id', $request->exam_id);
        }
        if ($request->term) {
            $query->where('term', $request->term);
        }

        $marks = $query->paginate($request->per_page ?? 50);

        return response()->json([
            'success' => true,
            'data' => $marks,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'exam_id' => 'required|exists:exams,id',
            'term' => 'required|string|max:20',
            'marks' => 'required|array|min:1',
            'marks.*.student_id' => 'required|exists:students,id',
            'marks.*.score' => 'required|numeric|min:0|max:100',
        ]);

        $saved = DB::transaction(function () use ($validated) {
            $count = 0;
            foreach ($validated['marks'] as $mark) {
                $grade = $this->calculateGrade($mark['score']);
                
                Mark::updateOrCreate(
                    [
                        'student_id' => $mark['student_id'],
                        'subject_id' => $validated['subject_id'],
                        'exam_id' => $validated['exam_id'],
                    ],
                    [
                        'score' => $mark['score'],
                        'grade' => $grade,
                        'term' => $validated['term'],
                    ]
                );
                $count++;
            }
            return $count;
        });

        return response()->json([
            'success' => true,
            'message' => "Marks saved for {$saved} students",
            'data' => ['saved' => $saved],
        ], 201);
    }

    public function reportCard(Student $student, Request $request)
    {
        $term = $request->term ?? 'Term 1';

        $marks = Mark::where('student_id', $student->id)
            ->where('term', $term)
            ->with('subject')
            ->get();

        $totalScore = $marks->sum('score');
        $average = $marks->count() > 0 ? $totalScore / $marks->count() : 0;

        return response()->json([
            'success' => true,
            'data' => [
                'student' => $student,
                'term' => $term,
                'marks' => $marks,
                'total' => $totalScore,
                'average' => round($average, 2),
                'gpa' => $this->calculateGPA($average),
            ],
        ]);
    }

    private function calculateGrade($score)
    {
        if ($score >= 90) return 'A';
        if ($score >= 80) return 'B';
        if ($score >= 70) return 'C';
        if ($score >= 60) return 'D';
        return 'F';
    }

    private function calculateGPA($average)
    {
        if ($average >= 90) return 4.0;
        if ($average >= 80) return 3.0;
        if ($average >= 70) return 2.0;
        if ($average >= 60) return 1.0;
        return 0.0;
    }
}
