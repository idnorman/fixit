<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;



class ServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::create([
            'name' => 'Air Conditioner'
        ]);
        Service::create([
            'name' => 'Mesin Cuci'
        ]);
        Service::create([
            'name' => 'Kulkas'
        ]);
        Service::create([
            'name' => 'Televisi'
        ]);
    }
}
