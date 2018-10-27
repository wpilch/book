<?php
/**
 * FakeSubscribersTableSeeder class.
 *
 * Seeder class for testing vibrant's tablable functionality.
 *
 * @author     E. Escudero <eescudero@aerobit.com>
 * @copyright  E. Escudero <eescudero@aerobit.com>
 *
 * This product includes original and copyrighted code developed at Aerobit, SA de CV.
 */

namespace Vibrant\Vibrant\Seeders;

use Illuminate\Database\Seeder;
use Faker;
use Vibrant\Vibrant\Library\VibrantTools;
use Illuminate\Support\Facades\DB;

class FakeSubscribersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $limit = 9828;

        for ($i = 0; $i < $limit; $i++) {
            $gender = (bool)random_int(0, 1) ? 'male' : 'female';
            $status = VibrantTools::getRandomWeightedElement(['active' => 85, 'inactive' => 10, 'blocked' => 5]);
            DB::table('fake_subscribers')->insert([ //,
                'uid' => $faker->ean8,
                'gender' => $gender,
                'first_name' => $faker->firstName($gender),
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->email,
                'phone' => $faker->phoneNumber,
                'dob' => $faker->date('Y-m-d', $max = '2000-1-1'),
                'status' => $status
            ]);
        }
    }
}
