<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     DB::table('users')->insert([
    //         [
    //             'name' => 'Gyan Guru Fitness',
    //             'email' => 'gyangurufitness@gmail.com',
    //             'password' => bcrypt('Gyanguru@123')
    //         ],
    //         [
    //             'name' => 'Big Bull Fitness',
    //             'email' => 'bigbull@gmail.com',
    //             'password' => bcrypt('Bigbull@123')
    //         ],
    //         [
    //             'name' => 'NepHub Fitness',
    //             'email' => 'nephub@gmail.com',
    //             'password' => bcrypt('Nephub@123')
    //         ]
    //     ]);
    // }
    public function run(): void
    {
        $faker = Faker::create();
        $chunkSize = 1000; // Number of records to insert in each batch
        $totalUsers = 200000;

        for ($i = 0; $i < $totalUsers; $i += $chunkSize) {
            $users = [];

            for ($j = 0; $j < $chunkSize; $j++) {
                $users[] = [
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'password' => Hash::make('password123') // Or generate a random password
                ];
            }

            DB::table('users')->insert($users);
        }
    }
}