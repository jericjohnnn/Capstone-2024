<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];

    public function tutors()
    {
        return $this->belongsToMany(Tutor::class, 'tutor_subjects');
    }

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_subjects');
    }
}
