<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->truncate();
       
      // $house = \DB::table('houses')->get();
       
       $houseIds = \DB::table('houses')->get()->pluck('id');
        
       $faker = \Faker\Factory::create();
        
        \DB::table('users')->insert([
            'name' => 'Stefan Blagojevic',
            'email' => 'fanste.blagoje@gmail.com',
            'password' => \Hash::make('12345'),
            'house_id' => $houseIds->random(),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        
        for ($i=1; $i<=30; $i++) {
        \DB::table('users')->insert([
            'name' => $faker->name,
            'email' => $faker->email,
            'password' => \Hash::make('12345'),
            'house_id' => $houseIds->random(),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        
        }
    }
}
