<?php

use Illuminate\Database\Seeder;

class PaymentNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = $faker = Faker\Factory::create();
        for ($i = 1; $i <= 30; $i++) {
            DB::table('payment_number')->insert(
                 [
                     'id' => $i,
                     'name' => $i
                 ]
            );
        }

//        foreach ($tests as $key) {
//
//        }
    }
}
