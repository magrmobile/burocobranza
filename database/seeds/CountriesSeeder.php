<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    //private $faker;

    public function run()
    {
        //$this->faker = $faker = Faker\Factory::create();
        $tests = array(
            [
                'name' => "San Salvador"
            ],
            [
                'name' => "Santa Ana"
            ],
            [
                'name' => "San Miguel"
            ]
        );

        foreach ($tests as $key) {
            DB::table('countries')->insert($key);
        }

    }
}
