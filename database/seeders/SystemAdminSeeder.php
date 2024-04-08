<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert(
            [
                'name' => 'SystemAdmin1',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin@123'),
                'UserRole' =>0
                
            ]
                 
        );
    }
}
