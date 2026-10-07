<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $query = ClassRoom::with(['school', 'teacher.user']);

        if ($request->grade_level) {
            $query->where('grade_level', $request->grade_level);
        }

        $classes = $query->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'data' => $classes,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'grade_level' => 'required|integer|between:1,12',
            'section' => 'required|string|max:10',
            'capacity' => 'nullable|integer|min:1',
            'teacher_id' => 'nullable|exists:teachers,id',
        ]);

        $validated['school_id'] = auth()->user()->school_id;
        $validated['capacity'] = $validated['capacity'] ?? 40;

        $class = ClassRoom::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Class created successfully',
            'data' => $class,
        ], 201);
    }

    public function show(ClassRoom $class)
    {
        $class->load(['school', 'teacher.user', 'timetables.subject']);

        return response()->json([
            'success' => true,
            'data' => $class,
        ]);
    }

    public function update(Request $request, ClassRoom $class)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:100',
            'capacity' => 'sometimes|integer|min:1',
            'teacher_id' => 'sometimes|nullable|exists:teachers,id',
        ]);

        $class->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Class updated successfully',
            'data' => $class,
        ]);
    }

    public function destroy(ClassRoom $class)
    {
        $class->delete();

        return response()->json([
            'success' => true,
            'message' => 'Class deleted successfully',
        ]);
    }

    public function students(ClassRoom $class)
    {
        $students = $class->students;
        
        return response()->json([
            'success' => true,
            'data' => $students,
        ]);
    }
}
