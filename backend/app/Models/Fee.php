<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id', 'student_id', 'fee_type', 'amount', 'due_date', 'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date',
    ];

    public function school() { return $this->belongsTo(School::class); }
    public function student() { return $this->belongsTo(Student::class); }
    public function payments() { return $this->hasMany(Payment::class); }
}
