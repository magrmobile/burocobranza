<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
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