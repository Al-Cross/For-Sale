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
        $this->call([
            CategorySeeder::class,
            SectionSeeder::class,
            CitySeeder::class,
            AdSeeder::class,
            ImageSeeder::class,
        ]);
    }
}
