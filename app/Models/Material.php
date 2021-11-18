<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'path',
        'name',
        'details',
        'user_id',
        'subject_id',
        'categories',
        'visited_at'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Gets categories as a collection
     *
     * @return Category
     */
    public function categories()
    {
        return Category::whereIn('id', explode(",", $this->categories))->get();
    }
}
