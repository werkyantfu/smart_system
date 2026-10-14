<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request) {
        return response()->json(['success' => true, 'data' => User::with('roles')->paginate(15)]);
    }
    public function store(Request $request) {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'school_id' => $request->school_id,
        ]);
        if ($request->role) $user->assignRole($request->role);
        return response()->json(['success' => true, 'data' => $user->load('roles')], 201);
    }
    public function show($id) {
        return response()->json(['success' => true, 'data' => User::with('roles')->findOrFail($id)]);
    }
    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email', 'school_id', 'is_active']));
        if ($request->password) $user->update(['password' => Hash::make($request->password)]);
        if ($request->role) $user->syncRoles([$request->role]);
        return response()->json(['success' => true, 'data' => $user->fresh('roles')]);
    }
    public function destroy($id) {
        User::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
