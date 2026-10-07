<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'school_id', 'teacher_id', 'name', 'grade_level', 'section', 'capacity',
    ];

    public function school() { return $this->belongsTo(School::class); }
    public function teacher() { return $this->belongsTo(Teacher::class); }
    public function students() { return $this->hasMany(Student::class, 'grade_level', 'grade_level'); }
    public function timetables() { return $this->hasMany(Timetable::class, 'class_id'); }
    public function attendance() { return $this->hasMany(Attendance::class, 'class_id'); }
}
