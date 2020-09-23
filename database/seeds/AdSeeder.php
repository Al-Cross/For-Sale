<?php

use App\Ad;
use Illuminate\Database\Seeder;

class AdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 31; $i++) {
            factory(Ad::class)->create(['section_id' => $i]);
        }
    }
}
