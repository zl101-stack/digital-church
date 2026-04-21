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
    
    public function registrations()
    {
        return $this->hasMany(ServiceRegistration::class);
    }
}
