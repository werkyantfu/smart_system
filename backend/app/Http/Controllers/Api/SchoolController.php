<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index() {
        return response()->json(['success' => true, 'data' => School::paginate(15)]);
    }
    public function store(Request $request) {
        return response()->json(['success' => true, 'data' => School::create($request->all())], 201);
    }
    public function show($id) {
        return response()->json(['success' => true, 'data' => School::findOrFail($id)]);
    }
    public function update(Request $request, $id) {
        $school = School::findOrFail($id);
        $school->update($request->all());
        return response()->json(['success' => true, 'data' => $school]);
    }
    public function destroy($id) {
        School::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
