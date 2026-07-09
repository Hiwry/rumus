<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@rumus.com'],
            [
                'name'     => 'Administrador RUMUS',
                'email'    => 'admin@rumus.com',
                'password' => Hash::make('rumus@admin123'),
            ]
        );
    }
}
