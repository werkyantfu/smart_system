<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'school_id', 'user_id', 'student_id', 'first_name', 'last_name',
        'date_of_birth', 'gender', 'address', 'guardian_name', 'guardian_phone',
        'grade_level', 'section', 'enrollment_date', 'status', 'photo_url',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'enrollment_date' => 'date',
    ];

    public function school() { return $this->belongsTo(School::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function attendance() { return $this->hasMany(Attendance::class); }
    public function marks() { return $this->hasMany(Mark::class); }
    public function fees() { return $this->hasMany(Fee::class); }
    public function bookLoans() { return $this->hasMany(BookLoan::class); }
}
