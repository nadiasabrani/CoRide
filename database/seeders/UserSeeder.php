<?php

namespace Database\Seeders;

use App\Models\Employe;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'entreprise_id' => 1,
            'name' => 'Admin Coride',
            'ville' => 'Casablanca',
            'role' => 'admin',
            'email' => 'admin@coride.ma',
            'password' => Hash::make('password'),
        ]);
    }
}
