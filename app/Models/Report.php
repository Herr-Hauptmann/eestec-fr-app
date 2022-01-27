<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'status_id',
        'user_id'
    ];

    public function status() {
        return $this->belongsTo(Status::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
