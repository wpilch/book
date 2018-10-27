<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PersonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $limit = 100;
        $building_options = ['Biochemii Analitecznej', 'Informatyki Stosowanej', 'Inżynierii Środowiska'];

        for ($i = 0; $i < $limit; $i++) {
            $gender = (bool)random_int(0, 1) ? 'male' : 'female';
            $room = rand(1,100);

            $building = $building_options[array_rand($building_options,1)];
            DB::table('persons')->insert([ //,
                'first_name' => $faker->firstName($gender),
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->email,
                'phone' => $faker->phoneNumber,
                'cellphone' => $faker->phoneNumber,
                'building' => $building,
                'room' => $room
            ]);
        }
    }
}
