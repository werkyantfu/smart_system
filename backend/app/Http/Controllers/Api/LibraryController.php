<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\LibraryBook;
use App\Models\BookLoan;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index(Request $request) {
        $books = LibraryBook::paginate($request->per_page ?? 15);
        return response()->json(['success' => true, 'data' => $books]);
    }
    public function store(Request $request) {
        $book = LibraryBook::create($request->all());
        return response()->json(['success' => true, 'data' => $book], 201);
    }
    public function show($id) {
        return response()->json(['success' => true, 'data' => LibraryBook::findOrFail($id)]);
    }
    public function update(Request $request, $id) {
        $book = LibraryBook::findOrFail($id);
        $book->update($request->all());
        return response()->json(['success' => true, 'data' => $book]);
    }
    public function destroy($id) {
        LibraryBook::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
    public function loans(Request $request) {
        return response()->json(['success' => true, 'data' => BookLoan::with(['book', 'student'])->paginate(15)]);
    }
    public function borrow(Request $request) {
        $loan = BookLoan::create($request->all());
        return response()->json(['success' => true, 'data' => $loan], 201);
    }
    public function returnBook($id) {
        $loan = BookLoan::findOrFail($id);
        $loan->update(['returned_at' => now(), 'status' => 'returned']);
        return response()->json(['success' => true, 'data' => $loan]);
    }
}
