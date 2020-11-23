<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeBills extends Seeder
{
    private $faker;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = $faker = Faker\Factory::create();
        $tests = array(
            [
                'name' => 'Combustible'
            ],
            [
                'name' => 'Comida'
            ],
            [
                'name' => 'Transporte'
            ]
        );

        foreach ($tests as $key) {
            DB::table('list_bill')->insert($key);
        }
    }
}
