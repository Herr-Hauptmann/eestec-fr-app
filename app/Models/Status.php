<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'event_id',
        'company_id',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function event() {
        return $this->belongsTo(Event::class);
    }

    public function reports() {
        return $this->hasMany(Report::class);
    }

    public function statusText() {
        if($this->status == 1) {
            return "Not contacted";
        }else if($this->status == 2) {
            return "Contacted, no answer";
        }else if($this->status == 3) {
            return "Contacted, waiting for reply";
        }else if($this->status == 4) {
            return "Accepted";
        }else if($this->status == 5) {
            return "Denied";
        }
    }

}
