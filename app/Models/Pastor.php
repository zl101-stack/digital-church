<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pastor extends Model
{
    protected $fillable = ['name', 'schedule'];

    public function counselings()
    {
        return $this->hasMany(Counseling::class);
    }
}
