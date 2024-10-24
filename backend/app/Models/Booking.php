<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'tutor_id',
        'student_id',
        'learning_mode',
        'location',
        'online_meeting_platform_id',
        'contact_number',
        'status'
    ];

    protected $casts = [
        'learning_mode' => 'string',
        'status' => 'string'
    ];

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function onlineMeetingPlatform()
    {
        return $this->belongsTo(OnlineMeetingPlatform::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'booking_subjects');
    }

    public function messages()
    {
        return $this->hasMany(BookingMessage::class);
    }
}
