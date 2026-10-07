<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'logo_url',
        'cover_image',
        'currency',
        'vat_rate',
        'service_charge_rate',
        'phone',
        'email',
        'address',
        'is_active',
    ];

    protected $casts = [
        'vat_rate' => 'decimal:2',
        'service_charge_rate' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function parents()
    {
        return $this->hasMany(ParentModel::class);
    }

    public function classes()
    {
        return $this->hasMany(ClassRoom::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function fees()
    {
        return $this->hasMany(Fee::class);
    }

    public function libraryBooks()
    {
        return $this->hasMany(LibraryBook::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }
}
