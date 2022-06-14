<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Transaction::create([
            'date'                  => '2022-06-13 01:01:20',
            'note'                  => 'Perbaikan lebih cepat',
            'is_accepted'           => 'waiting',
            'is_paid'               => 0,
            'user_id'               => 1,
            'partner_service_id'    => 1
        ]);

        Transaction::create([
            'date'                  => '2022-06-14 01:01:20',
            'note'                  => 'Datang Lebih awal',
            'is_accepted'           => 'accepted',
            'is_paid'               => 0,
            'user_id'               => 3,
            'partner_service_id'    => 2
        ]);

        Transaction::create([
            'date'                  => '2022-06-15 01:01:20',
            'note'                  => 'Pastikan datang diwaktu siang-sore',
            'is_accepted'           => 'rejected',
            'is_paid'               => 0,
            'user_id'               => 1,
            'partner_service_id'    => 3
        ]);

        Transaction::create([
            'date'                  => '2022-06-13 02:01:20',
            'note'                  => 'datang pagi',
            'is_accepted'           => 'finished',
            'is_paid'               => 0,
            'user_id'               => 3,
            'partner_service_id'    => 4
        ]);

        Transaction::create([
            'date'                  => '2022-06-13 03:01:20',
            'note'                  => 'Infokan biaya',
            'is_accepted'           => 'waiting',
            'is_paid'               => 0,
            'user_id'               => 1,
            'partner_service_id'    => 1
        ]);
    }
}
