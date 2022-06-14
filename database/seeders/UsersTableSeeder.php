<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // User::factory(20)->create();

        User::create([
            'name'      => 'Norman',
            'email'     => 'norman@fixit.id',
            'password'  => Hash::make('123456'),
            'phone'     => '08123456789',
            'role'      => 'customer',
            'address'   => 'Jl. Soebrantas, Tampan, Kota Pekanbaru'
        ]);

        User::create([
            'name'      => 'Idris Akbar',
            'email'     => 'idris@fixit.id',
            'password'  => Hash::make('123456'),
            'phone'     => '08223456789',
            'role'      => 'partner',
            'address'   => 'Jl. Delima, Tampan, Kota Pekanbaru'
        ]);

        User::create([
            'name'      => 'John Doe',
            'email'     => 'johndoe@fixit.id',
            'password'  => Hash::make('123456'),
            'phone'     => '08512345678',
            'role'      => 'customer',
            'address'   => 'Jl. Soekarno Hatta, Kota Pekanbaru'
        ]);

        User::create([
            'name'      => 'Mark Hoe',
            'email'     => 'markhoe@fixit.id',
            'password'  => Hash::make('123456'),
            'phone'     => '08587654321',
            'role'      => 'partner',
            'address'   => 'Jl. Riau Ujung No. 5, Kota Pekanbaru'
        ]);
    }
}
