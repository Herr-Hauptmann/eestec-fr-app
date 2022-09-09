<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'is_active',
        'user_id',
        'deadline',
    ];

    public function teamLeader() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function status() {
        return $this->hasMany(Status::class);
    }
}
