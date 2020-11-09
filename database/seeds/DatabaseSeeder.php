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
//         $this->call(UsersSeeder::class);
//         $this->call(JasaSeeder::class);
//         $this->call(SparePartSeeder::class);
//         $this->call(KeahlianTeknisiSeeder::class);
//         $this->call(ServiceSeeder::class);
//         $this->call(SparePartPictureSeeder::class);
         $this->call(ServiceSparePartSeeder::class);
    }
}
