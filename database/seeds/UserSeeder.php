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
                'name' => 'Administador',
                'username' => 'admin',
                'email' => 'admin@admin.com',
                'role' => 'admin',
                'password' => bcrypt('12345678')
            ],
            [
                'name' => 'Supervisor',
                'username' => 'supervisor',
                'email' => 'supervisor@supervisor.com',
                'role' => 'supervisor',
                'password' => bcrypt('12345678')
            ],
            [
                'name' => 'Agente',
                'username' => 'agente',
                'email' => 'agente@agente.com',
                'role' => 'agent',
                'password' => bcrypt('12345678')
            ]
        );

        foreach($tests as $key) {
            DB::table('users')->insert($key);
        }
    }
}
