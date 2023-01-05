<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'rating',
        'genre',
        'hour',
        'minute',
        'showing_date',
        'end_date',
        'poster',
    ];

    // Relationship with Schedule
    public function schedule() {
        return $this->hasMany(Schedule::class, 'movie');
    }
}
