<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title',
        'description',
        'date',
        'time',
        'location'
    ];

    // 🔥 relasi ke registrations (SUDAH BENAR, TIDAK DIUBAH)
    public function registrations()
    {
        return $this->hasMany(ServiceRegistration::class);
    }
}