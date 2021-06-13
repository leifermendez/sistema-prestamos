<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WalletSeeder extends Seeder
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
                'name' => 'Caja principal',
                'country' => 1,
                'address' => 'Madrid'
            ]
        );

        foreach ($tests as $key) {
            DB::table('wallet')->insert($key);
        }
    }
}
