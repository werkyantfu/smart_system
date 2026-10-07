<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id', 'title', 'author', 'isbn', 'category', 'total_copies', 'available_copies',
    ];

    public function school() { return $this->belongsTo(School::class); }
    public function bookLoans() { return $this->hasMany(BookLoan::class, 'book_id'); }
}
