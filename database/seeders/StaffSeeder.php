<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

        //
        public function run(): void
        {
            $faker = Faker::create();
            $staffs = [];
    
            for ($i = 0; $i < 20000; $i++) {
                $staffs[] = [
                    'name' => $faker->name,
                    'photo' => $faker->imageUrl(),
                    'gym_id' => $faker->numberBetween(1, 4), // Adjust according to your 'users' table data
                    'serial_no' => $faker->unique()->ean13,
                    'dob' => $faker->date(),
                    'address' => $faker->address,
                    'contact_no' => $faker->phoneNumber,
                    'position' => $faker->jobTitle,
                    'email' => $faker->unique()->safeEmail,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
    
                // Insert in batches of 1000 for better performance
                if (count($staffs) == 1000) {
                    DB::table('staffs')->insert($staffs);
                    $staffs = [];
                }
            }
    
            // Insert any remaining records
            if (!empty($staffs)) {
                DB::table('staffs')->insert($staffs);
            }
        }
    }

