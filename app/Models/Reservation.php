<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'name',
        'email',
        'genre',
        'quantity',
        'total_amount',
    ];
}
