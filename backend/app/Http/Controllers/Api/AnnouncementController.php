<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::with('school');

        if ($request->audience) {
            $query->where('audience', $request->audience);
        }

        $announcements = $query->orderBy('published_at', 'desc')
            ->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'data' => $announcements,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'audience' => 'required|in:all,teachers,students,parents',
        ]);

        $validated['school_id'] = auth()->user()->school_id;
        $validated['published_at'] = now();

        $announcement = Announcement::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Announcement created successfully',
            'data' => $announcement,
        ], 201);
    }

    public function show(Announcement $announcement)
    {
        return response()->json([
            'success' => true,
            'data' => $announcement,
        ]);
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return response()->json([
            'success' => true,
            'message' => 'Announcement deleted successfully',
        ]);
    }
}
