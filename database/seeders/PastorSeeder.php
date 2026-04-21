<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pastor;

class PastorSeeder extends Seeder
{
    public function run()
    {
        Pastor::create([
            'name' => 'Pastor Budi',
            'schedule' => 'Senin - Rabu'
        ]);

        Pastor::create([
            'name' => 'Pastor Shane',
            'schedule' => 'Kamis - Sabtu'
        ]);
    }
}
