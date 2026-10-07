<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id', 'name', 'code', 'grade_level', 'credit_hours',
    ];

    public function school() { return $this->belongsTo(School::class); }
    public function marks() { return $this->hasMany(Mark::class); }
    public function timetables() { return $this->hasMany(Timetable::class); }
}
