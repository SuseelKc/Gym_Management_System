<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $batchSize = 1000; // Batch size for insertion
        $totalRecords = 100000;

        // Generate and insert members in chunks
        for ($i = 0; $i < $totalRecords; $i += $batchSize) {
            $members = [];

            for ($j = 0; $j < $batchSize; $j++) {
                $members[] = [
                    'name' => $faker->name,
                    'photo' => $faker->imageUrl(),
                    'gym_id' => rand(1, 4), // Adjust according to existing gym/user IDs
                    'serial_no' => Str::random(10),
                    'dob' => $faker->optional()->date(), // Adjusted for date type
                    'address' => $faker->address,
                    'contact_no' => $faker->phoneNumber,
                    'email' => $faker->optional()->safeEmail,
                    'shifts' => $faker->randomElement(['Morning', 'Day', 'Evening']),
                    'pricing_id' => $faker->optional()->numberBetween(1, 3),
                    'start_date' => $faker->optional()->date(),
                    'end_date' => $faker->optional()->date(),
                    'status' => $faker->randomElement(['active', 'inactive', 'deleted']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Insert members in batches
            DB::table('members')->insert($members);
        }
    }
}
