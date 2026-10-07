<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Subject::with('school');

        if ($request->grade_level) {
            $query->where('grade_level', $request->grade_level);
        }

        $subjects = $query->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'data' => $subjects,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'nullable|string|max:20',
            'grade_level' => 'required|integer|between:1,12',
            'credit_hours' => 'nullable|integer|min:1',
        ]);

        $validated['school_id'] = auth()->user()->school_id;
        $validated['credit_hours'] = $validated['credit_hours'] ?? 1;

        $subject = Subject::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Subject created successfully',
            'data' => $subject,
        ], 201);
    }

    public function show(Subject $subject)
    {
        return response()->json([
            'success' => true,
            'data' => $subject,
        ]);
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:100',
            'code' => 'sometimes|nullable|string|max:20',
            'credit_hours' => 'sometimes|integer|min:1',
        ]);

        $subject->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Subject updated successfully',
            'data' => $subject,
        ]);
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

        return response()->json([
            'success' => true,
            'message' => 'Subject deleted successfully',
        ]);
    }
}
