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
         $this->call(UsersSeeder::class);
         $this->call(JasaSeeder::class);
         $this->call(SparePartSeeder::class);
         $this->call(SparePartPictureSeeder::class);
         $this->call(OrdersSeeder::class);
         $this->call(OrdersSparePartSeeder::class);
         $this->call(SaranSeeder::class);
         $this->call(ComplaintSeeder::class);
    }
}
