<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'address',
        'birthdate',
        'contact_number',
    ];

    protected $casts = [
        'birthdate' => 'date',
    ];

    //relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
