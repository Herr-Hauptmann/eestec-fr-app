<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'website',
        'description',
        'comment',
        'contact_email',
        'contact_phone',
        'contact_person'
    ];

    public function status() {
        return $this->hasMany(Status::class);
    }

    public function contact(){
        return $this->hasMany(Contact::class);
    }
}
