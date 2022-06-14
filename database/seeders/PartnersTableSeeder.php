<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartnersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Partner::create([
            'name'          => 'Toko Cahaya Asia',
            'description'   => 'Penyedia jasa reparasi alat-alat elektronik berkualitas, murah dan cepat',
            'phone'         => '0761234567',
            'address'       => 'Jl. Pemuda No. 3 Pekanbaru, Riau',
            'user_id'       => 2
        ]);

        Partner::create([
            'name'          => 'Bengkel Melektronika',
            'description'   => 'Reparasi alat-alat elektronik termurah, tercepat, termudah dan terbaik',
            'phone'         => '0811766776',
            'address'       => 'Jl. Pembangunan Karya No. 5 Pekanbaru, Riau',
            'user_id'       => 4
        ]);
    }
}
