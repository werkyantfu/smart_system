<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::with(['school', 'user']);

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $teachers = $query->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'data' => $teachers,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'phone' => 'nullable|string|max:20',
            'qualification' => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'hire_date' => 'required|date',
            'salary' => 'nullable|numeric|min:0',
        ]);

        // Create user first
        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'role' => 'teacher',
            'school_id' => auth()->user()->school_id,
        ]);

        // Generate employee ID
        $count = Teacher::where('school_id', auth()->user()->school_id)->count() + 1;
        
        $teacher = Teacher::create([
            'school_id' => auth()->user()->school_id,
            'user_id' => $user->id,
            'employee_id' => 'TCH-' . date('Y') . '-' . str_pad($count, 3, '0', STR_PAD_LEFT),
            'qualification' => $validated['qualification'],
            'specialization' => $validated['specialization'] ?? null,
            'hire_date' => $validated['hire_date'],
            'salary' => $validated['salary'] ?? null,
            'status' => 'active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Teacher registered successfully',
            'data' => $teacher,
        ], 201);
    }

    public function show(Teacher $teacher)
    {
        $teacher->load(['school', 'user', 'classes', 'timetables']);

        return response()->json([
            'success' => true,
            'data' => $teacher,
        ]);
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'qualification' => 'sometimes|string|max:255',
            'specialization' => 'sometimes|nullable|string|max:255',
            'salary' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|in:active,on_leave,terminated',
        ]);

        $teacher->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Teacher updated successfully',
            'data' => $teacher,
        ]);
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return response()->json([
            'success' => true,
            'message' => 'Teacher deleted successfully',
        ]);
    }
}
