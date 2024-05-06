<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => "82da6c32-366b-4095-a5e5-0933b7833a0f",
            'name' => 'Admin',
            'email' => 'admin@admin',
            'password' => Hash::make('admin'),
        ]);
    }
}
