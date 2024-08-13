<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PricingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $packageNames = [
            'Monthly',
            'Yearly',
            'Daily',
            'Weekly',
            'Bi-Weekly',
            'Quarterly',
            'Half-Yearly',
            'Pay-As-You-Go',
            'Lifetime',
            'Trial'
        ];

        $pricing = [];
        for ($i = 0; $i < 20; $i++) {
            $pricing[] = [
                'name' => $faker->randomElement($packageNames),
                'costs' => $faker->randomFloat(3, 10, 1000), // Random float with 3 decimal places
                'costs_type' => $faker->randomElement(['monthly', 'annual', 'daily', 'weekly']),
                'start_date' => $faker->optional()->date(),
                'end_date' => $faker->optional()->date(),
                'gym_id' => rand(1, 3), // Adjust according to the existing gym/user ids
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('pricing')->insert($pricing);
    }
}
