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
        'note',
        'nickname',
        'is_slot',
        'booked_by',
        'booking_note',
    ];

    protected $casts = [
        'is_slot'      => 'boolean',
        'is_anonymous' => 'boolean',
    ];

    public function pastor()
    {
        return $this->belongsTo(Pastor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookedByUser()
    {
        return $this->belongsTo(User::class, 'booked_by');
    }

    /** Apakah slot ini sudah diambil user */
    public function isBooked(): bool
    {
        return $this->is_slot && !is_null($this->booked_by);
    }
}
