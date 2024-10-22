<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
    ];

    //relationships
    public function role()
    {
        return $this->belongsTo(AdminRole::class);
    }
}
