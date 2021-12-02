<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class HousesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('houses')->truncate();
        
        $faker = \Faker\Factory::create();
        
        for($i = 1; $i <= 10; $i++) {
         \DB::table('houses')->insert([
            'name' => $faker->company,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
       }
    }
}
