<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'cinema_id',
        'date',
        'amount',
        'seat_left',
    ];

     // Relationship with Reservation
     public function reservation() {
        return $this->hasMany(Reservation::class, 'schedule_id');
    }
}
