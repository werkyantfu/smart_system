<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'school_id', 'user_id', 'employee_id', 'qualification',
        'specialization', 'hire_date', 'salary', 'status',
    ];

    protected $casts = [
        'hire_date' => 'date',
        'salary' => 'decimal:2',
    ];

    public function school() { return $this->belongsTo(School::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function classes() { return $this->hasMany(ClassRoom::class); }
    public function timetables() { return $this->hasMany(Timetable::class); }
}
