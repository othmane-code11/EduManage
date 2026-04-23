<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::whereIn('email', ['admin1@example.com', 'admin2@example.com'])->delete();

        // Admins
        User::updateOrCreate(
            ['email' => 'yahya@gmail.com'],
            [
                'name' => 'Yahya Admin',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'othmane@gmail.com'],
            [
                'name' => 'Othmane Admin',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
            ]
        );

        // Formateurs
        User::updateOrCreate(
            ['email' => 'formateur1@example.com'],
            [
                'name' => 'Formateur One',
                'password' => Hash::make('password123'),
                'role' => 'formateur',
            ]
        );

        User::updateOrCreate(
            ['email' => 'formateur2@example.com'],
            [
                'name' => 'Formateur Two',
                'password' => Hash::make('password123'),
                'role' => 'formateur',
            ]
        );

        User::updateOrCreate(
            ['email' => 'formateur3@example.com'],
            [
                'name' => 'Formateur Three',
                'password' => Hash::make('password123'),
                'role' => 'formateur',
            ]
        );

        User::updateOrCreate(
            ['email' => 'formateur4@example.com'],
            [
                'name' => 'Formateur Four',
                'password' => Hash::make('password123'),
                'role' => 'formateur',
            ]
        );
    }
}