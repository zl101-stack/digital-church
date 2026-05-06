<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'note',
        'date',
        'is_anonymous',
        'payment_method',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
