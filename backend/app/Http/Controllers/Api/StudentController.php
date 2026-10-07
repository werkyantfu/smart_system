<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with(['school', 'user']);

        if ($request->grade_level) {
            $query->where('grade_level', $request->grade_level);
        }
        if ($request->section) {
            $query->where('section', $request->section);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->search}%")
                  ->orWhere('last_name', 'like', "%{$request->search}%")
                  ->orWhere('student_id', 'like', "%{$request->search}%")
                  ->orWhere('guardian_phone', 'like', "%{$request->search}%");
            });
        }

        $students = $query->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'data' => $students,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male,female',
            'address' => 'nullable|string',
            'guardian_name' => 'required|string|max:255',
            'guardian_phone' => 'required|string|max:20',
            'grade_level' => 'required|integer|between:1,12',
            'section' => 'nullable|string|max:10',
            'enrollment_date' => 'required|date',
        ]);

        // Generate student ID
        $schoolId = auth()->user()->school_id;
        $count = Student::where('school_id', $schoolId)->count() + 1;
        $validated['student_id'] = 'STU-' . date('Y') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
        $validated['school_id'] = $schoolId;
        $validated['status'] = 'enrolled';

        $student = Student::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Student registered successfully',
            'data' => $student,
        ], 201);
    }

    public function show(Student $student)
    {
        $student->load(['school', 'user', 'attendance', 'marks', 'fees']);

        return response()->json([
            'success' => true,
            'data' => $student,
        ]);
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'first_name' => 'sometimes|string|max:100',
            'last_name' => 'sometimes|string|max:100',
            'guardian_phone' => 'sometimes|string|max:20',
            'grade_level' => 'sometimes|integer|between:1,12',
            'section' => 'sometimes|nullable|string|max:10',
            'status' => 'sometimes|in:enrolled,active,transferred,graduated',
        ]);

        $student->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully',
            'data' => $student,
        ]);
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return response()->json([
            'success' => true,
            'message' => 'Student deleted successfully',
        ]);
    }
}
