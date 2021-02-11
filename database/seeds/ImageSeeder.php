<?php

use App\Image;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 97; $i++) {
        	Image::create([
        		'ad_id' => $i,
        		'path' => '/images/' . $i . '.jpg'
        	]);
        }
    }
}
