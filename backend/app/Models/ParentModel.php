<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentModel extends Model
{
    use HasFactory;

    protected $table = 'parents';

    protected $fillable = [
        'school_id', 'user_id', 'phone', 'relation', 'occupation', 'address',
    ];

    public function school() { return $this->belongsTo(School::class); }
    public function user() { return $this->belongsTo(User::class); }
}
