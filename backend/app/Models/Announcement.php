<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id', 'title', 'body', 'audience', 'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function school() { return $this->belongsTo(School::class); }
}
