<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Counseling extends Model
{
    protected $fillable = [
        'user_id',
        'pastor_id',
        'date',
        'time',
        'duration',
        'is_anonymous',
        'note'
    ];

    public function pastor()
    {
        return $this->belongsTo(Pastor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
