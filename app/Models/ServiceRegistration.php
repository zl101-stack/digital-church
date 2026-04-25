<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRegistration extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'service_id',
        'position',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
