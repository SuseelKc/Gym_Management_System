<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $equipments = [];

        for ($i = 0; $i < 100000; $i++) {
            $equipments[] = [
                'name' => $faker->word,
                'image' => $faker->imageUrl(),
                'serial_no' => $faker->unique()->ean13,
                'weight' => $faker->randomFloat(2, 1, 1000), // Weight between 1 and 1000 kg
                'qty' => $faker->numberBetween(1, 50),
                'maintenance_period' => $faker->numberBetween(1, 12), // Maintenance period in months
                'maintenance_type' => $faker->randomElement(['Monthly', 'Quarterly', 'Yearly']),
                'upcoming_date' => $faker->dateTimeBetween('now', '+2 years')->format('Y-m-d'),
                'gym_id' => $faker->numberBetween(1, 4), // Adjust according to your 'users' table data
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Insert in batches of 1000 for better performance
            if (count($equipments) == 1000) {
                DB::table('equipments')->insert($equipments);
                $equipments = [];
            }
        }

        // Insert any remaining records
        if (!empty($equipments)) {
            DB::table('equipments')->insert($equipments);
        }
    }
}
