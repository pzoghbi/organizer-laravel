<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'name',
        'start',
        'end',
        'is_active'
    ];

    /**
     * Get the lectures for the schedule.
     */
    function lectures() {
        return $this->hasMany(Lecture::class);
    }

    public function groupLectures() {
        return $this->lectures->sortBy('start')->groupBy('day');
    }
}
