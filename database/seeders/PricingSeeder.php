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
    
            // Define package names and cost types
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
                'Trial',
            ];
    
            $costTypes = ['monthly', 'annual', 'daily', 'weekly'];
    
            // Batch size for insertion
            $batchSize = 1000;  // Insert 1000 records at a time
            $totalRecords = 5000;
    
            // Seed the pricing table
            for ($i = 0; $i < $totalRecords; $i += $batchSize) {
                $pricing = [];
    
                for ($j = 0; $j < $batchSize; $j++) {
                    $pricing[] = [
                        'name' => $faker->randomElement($packageNames),
                        'costs' => $faker->randomFloat(3, 10, 1000), // Random float with 3 decimal places
                        'costs_type' => $faker->randomElement($costTypes),
                        'start_date' => $faker->optional()->date(),
                        'end_date' => $faker->optional()->date(),
                        'gym_id' => rand(1, 3), // Adjust according to the existing gym/user IDs
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
    
                // Insert in batches
                DB::table('pricing')->insert($pricing);
            }
        }
    }

