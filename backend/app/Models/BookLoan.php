<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookLoan extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'book_id', 'borrowed_at', 'due_date', 'returned_at', 'fine_amount', 'status',
    ];

    protected $casts = [
        'borrowed_at' => 'date',
        'due_date' => 'date',
        'returned_at' => 'date',
        'fine_amount' => 'decimal:2',
    ];

    public function student() { return $this->belongsTo(Student::class); }
    public function book() { return $this->belongsTo(LibraryBook::class, 'book_id'); }
}
