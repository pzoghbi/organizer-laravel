<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoItem extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'todo_id',
        'title',
        'is_active'
    ];
}
