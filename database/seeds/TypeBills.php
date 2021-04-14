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
                'name' => 'Gasolina'
            ],
            [
                'name' => 'Almuerzo'
            ],
            [
                'name' => 'Sueldo'
            ],
            [
                'name' => 'Sueldo Supervisor'
            ],
            [
                'name' => 'Recarga'
            ],
            [
                'name' => 'Aceite'
            ],
            [
                'name' => 'Moto'
            ],
            [
                'name' => 'Sistema'
            ],
            [
                'name' => 'Transito'
            ],
            [
                'name' => 'Arriendo'
            ],
            [
                'name' => 'Servicios'
            ],
            [
                'name' => 'Retiro de Caja'
            ],
            [
                'name' => 'Para otro Cobro'
            ],
            [
                'name' => 'Ajuste de Caja'
            ],
            [
                'name' => 'Deposito'
            ],
            [
                'name' => 'Policia'
            ]
        );

        foreach ($tests as $key) {
            DB::table('list_bill')->insert($key);
        }
    }
}
