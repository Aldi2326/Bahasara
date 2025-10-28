<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'balaibahasa',            // login pakai ini
            'email' => 'pengaduankbpj@gmail.com', // masih wajib ada karena default table pakai email
            'password' => Hash::make('balaiadmin123'), // login pakai ini
            'role' => Hash::make('superadmin'), // login pakai ini
        ]);
    }
}
