<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgentHasSeeder extends Seeder
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
                'id_user_agent' => '3',
                'id_supervisor' => '2',
                'id_wallet' => '1',
                'base' => '100000'
            ]
        );

        foreach ($tests as $key) {
            DB::table('agent_has_supervisor')->insert($key);
        }
    }
}
