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

        $members = [];
        for ($i = 0; $i < 10000; $i++) {
            $members[] = [
                'name' => $faker->name,
                'photo' => $faker->imageUrl(),
                'user_id' => rand(1, 4), // Adjust according to the existing user ids
                'serial_no' => Str::random(10),
                'dob' => $faker->date(),
                'address' => $faker->address,
                'contact_no' => $faker->phoneNumber,
                'email' => $faker->safeEmail,
                'shifts' => rand(1, 3), // Adjust according to your Shifts enum values
                'status' => $faker->randomElement(['active', 'inactive', 'deleted']),
                'pricing_id' => rand(1, 3),
                'pricing_type' => null,
                'pricing_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert in chunks to handle large data insertion
        $chunks = array_chunk($members, 1000);
        foreach ($chunks as $chunk) {
            DB::table('members')->insert($chunk);
        }
    }
}
