<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'subject_id',
        'todo_id',
        'title',
        'details',
        'type',
        'datetime',
        'active'
    ];

    public function subject()
    {
        return $this->belongsTo(\App\Models\Subject::class, 'subject_id');
    }
}
