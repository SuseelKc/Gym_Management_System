<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Gyan Guru Fitness',
                'email' => 'gyangurufitness@gmail.com',
                'password' => bcrypt('Gyanguru@123')
            ],
            [
                'name' => 'Big Bull Fitness',
                'email' => 'bigbull@gmail.com',
                'password' => bcrypt('Bigbull@123')
            ],
            [
                'name' => 'NepHub Fitness',
                'email' => 'nephub@gmail.com',
                'password' => bcrypt('Nephub@123')
            ]
        ]);
    }
}