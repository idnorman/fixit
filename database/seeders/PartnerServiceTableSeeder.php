<?php

namespace Database\Seeders;

use App\Models\PartnerService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartnerServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PartnerService::create([
            'price'         => '100000',
            'partner_id'    => 1,
            'service_id'    => 4,
            'note'          => 'Hanya Menerima TV LCD/Plasma (tidak menerima TV tabung)'
        ]);

        PartnerService::create([
            'price'         => '150000',
            'partner_id'    => 1,
            'service_id'    => 3,
            'note'          => 'Reparasi Kulkas mini dan kulkas biasa, termasuk freezer'
        ]);

        PartnerService::create([
            'price'         => '250000',
            'partner_id'    => 1,
            'service_id'    => 1,
            'note'          => 'Reparasi dan jasa cleaning AC'
        ]);

        PartnerService::create([
            'price'         => '50000',
            'partner_id'    => 2,
            'service_id'    => 4,
            'note'          => 'Hanya Menerima TV Tabung (TV lama), tidak TV LCD/Plasma'
        ]);

        PartnerService::create([
            'price'         => '150000',
            'partner_id'    => 2,
            'service_id'    => 3,
            'note'          => 'Reparasi Kulkas (tidak menerima freezer)'
        ]);

        PartnerService::create([
            'price'         => '250000',
            'partner_id'    => 2,
            'service_id'    => 1,
            'note'          => 'Jasa cleaning AC dan perbaikan panggilan'
        ]);

        PartnerService::create([
            'price'         => '250000',
            'partner_id'    => 2,
            'service_id'    => 2,
            'note'          => 'Jasa reparasi Mesin Cuci panggilan'
        ]);

    }
}
