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
    private $faker;

    public function run()
    {
        $this->faker = $faker = Faker\Factory::create();
        $tests = array(
            [
                'name' => $this->faker->country
            ],
            [
                'name' => $this->faker->country
            ],
            [
                'name' => $this->faker->country
            ]
        );

        foreach ($tests as $key) {
            DB::table('countrys')->insert($key);
        }

    }
}
