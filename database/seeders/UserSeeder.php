<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Muhammad Rihaz S.Kom',
            'id_opd' => '1',
            'email' => 'MuhammadRihaz@jdac.go.id',
            'password' => Hash::make('sayangaisy123'),
            'role' => 'admin',
            'photo' => 'rihaz.jpg',
        ]);
    }
}
