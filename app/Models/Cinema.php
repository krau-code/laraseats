<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cinema extends Model
{
    use HasFactory;

    protected $fillable = [
        'cinema_name',
        'seating_capacity',
    ];

    // Relationship with Schedule
    public function schedule() {
        return $this->hasMany(Schedule::class, 'cinema_id');
    }
}
