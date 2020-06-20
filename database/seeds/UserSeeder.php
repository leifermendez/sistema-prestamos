<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
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
                'name' => 'Administrador',
                'email' => 'admin@admin.com',
                'level' => 'admin',
                'password' => bcrypt('12345678')
            ],
            [
                'name' => 'Supervisor',
                'email' => 'supervisor@supervisor.com',
                'level' => 'supervisor',
                'password' => bcrypt('12345678')
            ],
            [
                'name' => 'Agente',
                'email' => 'agente@agente.com',
                'level' => 'agent',
                'password' => bcrypt('12345678')
            ]
        );

        foreach ($tests as $key) {
            DB::table('users')->insert($key);
        }

    }
}