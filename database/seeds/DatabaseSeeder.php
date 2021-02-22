<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UserSeeder::class);
         $this->call(CountriesSeeder::class);
         $this->call(PaymentNumberSeeder::class);
         $this->call(TypeBills::class);
         $this->call(AgentHasSeeder::class);
         $this->call(WalletSeeder::class);
    }
}
