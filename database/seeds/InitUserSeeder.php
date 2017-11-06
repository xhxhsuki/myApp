<?php

use Illuminate\Database\Seeder;

class InitUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::create([
             'name' => "tph",
             'phone' => '18262280465',
             'password' => bcrypt('aaa123456')
         ]);
    }
}
