<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'task_id',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function itemsf()
    {
        $this->hasMany(TodoItem::class);
    }
}
