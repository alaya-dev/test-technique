<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LeaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Insertion d'un utilisateur leader dans la table 'users'
        DB::table('users')->insert([
            'name' => 'Leader',
            'email' => '3leya21@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'leader',
        ]);
        
    }
}
