<?php

use App\Ad;
use App\User;
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
        $faker = Faker\Factory::create();

        $peter = factory(User::class)->create([
            'name' => 'Peter Jefferson',
            'about' => 'Small retailer with exceptional sale skills.',
            'address' => '08232, Berlin',
            'type' => 'advanced',
            'ad_limit' => 7
        ]);

        factory(Ad::class)->create([
            'section_id' => 1,
            'user_id' => $peter->id,
            'city_id' => 3,
            'title' => 'Laptop MSi 2923 6GB, 2.3GHz',
            'price' => number_format(980, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'seller',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 1,
            'user_id' => $peter->id,
            'city_id' => 3,
            'title' => 'Laptop Lenovo IdeaPad 12GB, 3.3GHz',
            'price' => number_format(1239, 2, '.', ''),
            'type' => 'business',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 1,
            'city_id' => 143,
            'title' => 'PC 16GB, 3.1GHz in good condition',
            'price' => number_format(781, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'buyer',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 1,
            'city_id' => 143,
            'title' => 'PC Windows 10, 8GB, 2.1GHz big screen',
            'price' => number_format(1001, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 1,
            'city_id' => 39,
            'title' => 'MacBook Air, 8GB, 2.1GHz',
            'price' => number_format(1001, 2, '.', ''),
            'type' => 'business',
            'condition' => 'new',
            'delivery' => 'personal handover',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 1,
            'city_id' => 110,
            'title' => 'Apple iMac 16GB, 3.1GHz touchscreen',
            'price' => number_format(2800, 2, '.', ''),
            'type' => 'business',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 2,
            'city_id' => 110,
            'title' => 'iPhone 6S',
            'price' => number_format(1001, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'personal handover',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 2,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'iPhone 7S',
            'price' => number_format(998, 2, '.', ''),
            'type' => 'business',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 2,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Android Phone With Remarkable Camera',
            'price' => number_format(722, 2, '.', ''),
            'type' => 'business',
            'condition' => 'used',
            'delivery' => 'seller',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 2,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Samsung 8',
            'price' => number_format(645, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'buyer',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 2,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Google Pixel',
            'price' => number_format(798, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'personal handover',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 3,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'White Keyboard',
            'price' => number_format(112, 2, '.', ''),
            'type' => 'business',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 3,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Light Keyboard',
            'price' => number_format(291, 2, '.', ''),
            'type' => 'business',
            'condition' => 'used',
            'delivery' => 'buyer',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 3,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Apple Computer Mouse',
            'price' => number_format(189, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 3,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Mouse For Everyday Use',
            'price' => number_format(998, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'buyer',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 3,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Futuristic Mouse',
            'price' => number_format(398, 2, '.', ''),
            'type' => 'business',
            'condition' => 'new',
            'delivery' => 'buyer',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 4,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Huge 80" TV',
            'price' => number_format(4522, 2, '.', ''),
            'type' => 'business',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 4,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Android TV',
            'price' => number_format(998, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'buyer',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 4,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Samsung TV',
            'price' => number_format(1298, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'seller',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 4,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Home TV',
            'price' => number_format(798, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'buyer',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 4,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Android 55" Smart TV',
            'price' => number_format(998, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'buyer',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 5,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Classy Black HeadPhones',
            'price' => number_format(698, 2, '.', ''),
            'type' => 'business',
            'condition' => 'new',
            'delivery' => 'personal handover',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 5,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Powerful Headset',
            'price' => number_format(598, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 5,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'White Earbuds',
            'price' => number_format(92, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'seller',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 5,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'DJ Headset',
            'price' => number_format(293, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'buyer',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 5,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Surround System',
            'price' => number_format(498, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 6,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Garmin GPS',
            'price' => number_format(86, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'buyer',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 6,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Navigation Device',
            'price' => number_format(998, 2, '.', ''),
            'type' => 'business',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 6,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Car Navigation',
            'price' => number_format(398, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'personal handover',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 6,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Mini Navigation Device',
            'price' => number_format(27, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'buyer',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 6,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'GPS Receiver',
            'price' => number_format(698, 2, '.', ''),
            'type' => 'business',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 7,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Medium Air Conditioner',
            'price' => number_format(898, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'seller',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 7,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'High Output Air Conditioner',
            'price' => number_format(998, 2, '.', ''),
            'type' => 'business',
            'condition' => 'new',
            'delivery' => 'buyer',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 7,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Ceiling Fan',
            'price' => number_format(71, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'personal handover',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 7,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Powerful Air Conditioning System',
            'price' => number_format(1598, 2, '.', ''),
            'type' => 'business',
            'condition' => 'new',
            'delivery' => 'buyer',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 7,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Ceiling Fan, Golden',
            'price' => number_format(93, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 8,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Vintage Camera',
            'price' => number_format(211, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'personal handover',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 8,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Camera For Best Night Pics',
            'price' => number_format(161, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'seller',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 8,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'High-End Camera',
            'price' => number_format(761, 2, '.', ''),
            'type' => 'business',
            'condition' => 'used',
            'delivery' => 'seller',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 8,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Polaroid Camera',
            'price' => number_format(569, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'personal handover',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 8,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Black Camera',
            'price' => number_format(299, 2, '.', ''),
            'type' => 'business',
            'condition' => 'new',
            'delivery' => 'buyer',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 8,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Drone Camera',
            'price' => number_format(411, 2, '.', ''),
            'type' => 'business',
            'condition' => 'used',
            'delivery' => 'seller',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 9,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'White Pullover',
            'price' => number_format(35, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'seller',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 9,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Silver Shawl',
            'price' => number_format(98, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 9,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Denim Jacket, Women',
            'price' => number_format(161, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'personal handover',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 9,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Warm Kid Set',
            'price' => number_format(56, 2, '.', ''),
            'type' => 'business',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 9,
            'user_id' => $peter->id,
            'city_id' => 110,
            'title' => 'Striped Pullover, Men',
            'price' => number_format(77, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 10,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Kid Shoes',
            'price' => number_format(111, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 10,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Snickers Vintage, Unisex',
            'price' => number_format(50, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'buyer',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 10,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Pink Shoes',
            'price' => number_format(21, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'buyer',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 10,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Red Shoes',
            'price' => number_format(511, 2, '.', ''),
            'type' => 'business',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 10,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Men Shoes',
            'price' => number_format(111, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'personal handover',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 11,
            'user_id' => $peter->id,
            'city_id' => 3,
            'title' => 'Child Hat',
            'price' => number_format(27, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'seller',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 11,
            'user_id' => $peter->id,
            'city_id' => 110,
            'title' => 'Straw Hat For Women',
            'price' => number_format(97, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'buyer',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 11,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Colorful Warm Shawl',
            'price' => number_format(22, 2, '.', ''),
            'type' => 'business',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 11,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Blue Shawl',
            'price' => number_format(26, 2, '.', ''),
            'type' => 'business',
            'condition' => 'used',
            'delivery' => 'seller',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 11,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Warm Blanket',
            'price' => number_format(72, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'buyer',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 12,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Old Pocket Watch',
            'price' => number_format(322, 2, '.', ''),
            'type' => 'business',
            'condition' => 'used',
            'delivery' => 'buyer',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 12,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Small Alarm Clock',
            'price' => number_format(52, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'personal handover',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 12,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Multifunctional Watch',
            'price' => number_format(622, 2, '.', ''),
            'type' => 'business',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 12,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Classy Watch',
            'price' => number_format(1222, 2, '.', ''),
            'type' => 'business',
            'condition' => 'new',
            'delivery' => 'buyer',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 12,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Handcrafted Handpiece',
            'price' => number_format(922, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 13,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Brown-furred Cat',
            'price' => number_format(222, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'buyer',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 13,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'White-pawned Cat',
            'price' => number_format(11, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 13,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Brown Cat',
            'price' => number_format(26, 2, '.', ''),
            'type' => 'business',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 14,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'White Dog',
            'price' => number_format(226, 2, '.', ''),
            'type' => 'business',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 14,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'White-furred Dog',
            'price' => number_format(336, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'buyer',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 14,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Light Brown Dog',
            'price' => number_format(771, 2, '.', ''),
            'type' => 'business',
            'condition' => 'new',
            'delivery' => 'buyer',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 15,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Yellow Fish',
            'price' => number_format(216, 2, '.', ''),
            'type' => 'business',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 15,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Star Fish',
            'price' => number_format(318, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'buyer',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 15,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Blue Fish',
            'price' => number_format(111, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'personal handover',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 16,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Bird Couple',
            'price' => number_format(1119, 2, '.', ''),
            'type' => 'business',
            'condition' => 'new',
            'delivery' => 'personal handover',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 16,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Dark-fethered Bird',
            'price' => number_format(111, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 16,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Blue-feathered Bird',
            'price' => number_format(388, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'personal handover',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 17,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Cat Food',
            'price' => number_format(18, 2, '.', ''),
            'type' => 'business',
            'condition' => 'new',
            'delivery' => 'buyer',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 17,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Crunchy Cat Food',
            'price' => number_format(25, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 18,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Vintage Red Car',
            'price' => number_format(280111, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'personal handover',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 18,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Black Porsche',
            'price' => number_format(111999, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'buyer',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 18,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Modified Mustang GT',
            'price' => number_format(56238, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'seller',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 18,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'White Vintage Car',
            'price' => number_format(96238, 2, '.', ''),
            'type' => 'business',
            'condition' => 'used',
            'delivery' => 'seller',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 18,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Black BMW',
            'price' => number_format(36751, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'buyer',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 18,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Classic Ford',
            'price' => number_format(36811, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'buyer',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 19,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'White Wheel Rim',
            'price' => number_format(200, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 19,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Black Mercedes Wheel Rim',
            'price' => number_format(320, 2, '.', ''),
            'type' => 'business',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 20,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Fully Equipped Caravan',
            'price' => number_format(12238, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'personal handover',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 20,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'White Caravan',
            'price' => number_format(5129, 2, '.', ''),
            'type' => 'business',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 21,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'City Cruiser',
            'price' => number_format(56238, 2, '.', ''),
            'type' => 'business',
            'condition' => 'used',
            'delivery' => 'buyer',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 21,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'MAN Trailer Truck',
            'price' => number_format(96238, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 22,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => '6-room Suburban House',
            'price' => number_format(556238, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'buyer',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 22,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Spacious Condo',
            'price' => number_format(981238, 2, '.', ''),
            'type' => 'business',
            'condition' => 'used',
            'delivery' => 'buyer',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 23,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Rental property',
            'price' => number_format(540, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'buyer',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 23,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Condo For Rent',
            'price' => number_format(2100, 2, '.', ''),
            'type' => 'business',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 22,
            'city_id' => $faker->numberBetween(1, 365),
            'title' => 'Family Hause',
            'price' => number_format(256288, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'buyer',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 27,
            'city_id' => 143,
            'title' => 'Repair Tools',
            'price' => number_format(227, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'buyer',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 27,
            'city_id' => 110,
            'title' => 'Artist Equipment',
            'price' => number_format(118, 2, '.', ''),
            'type' => 'private',
            'condition' => 'used',
            'delivery' => 'seller',
            'featured' => false
        ]);

        factory(Ad::class)->create([
            'section_id' => 25,
            'user_id' => $peter->id,
            'city_id' => 3,
            'title' => 'Maintainance Tools For Escavators',
            'price' => number_format(11800, 2, '.', ''),
            'type' => 'business',
            'condition' => 'new',
            'delivery' => 'seller',
            'featured' => true
        ]);

        factory(Ad::class)->create([
            'section_id' => 28,
            'city_id' => 3,
            'title' => 'English For Kids',
            'price' => number_format(219, 2, '.', ''),
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'buyer',
            'featured' => true
        ]);

        for ($i=1; $i <= 31; $i++) {
            factory(Ad::class)->create([
                'section_id' => $i,
                'city_id' => $faker->numberBetween(1, 365),
                'type' => 'private',
                'featured' => true,
                'created_at' => now()->subMinutes(5)
            ]);
        }

        for ($i=1; $i <= 31; $i++) {
            factory(Ad::class)->create([
                'section_id' => $i,
                'city_id' => $faker->numberBetween(1, 365),
                'type' => 'private',
                'featured' => false,
                'created_at' => now()->subMinutes(5)
            ]);
        }

        for ($i=1; $i <= 31; $i++) {
            factory(Ad::class)->create([
                'section_id' => $i,
                'city_id' => $faker->numberBetween(1, 365),
                'type' => 'business',
                'featured' => true,
                'created_at' => now()->subMinutes(5)
            ]);
        }

        for ($i=1; $i <= 31; $i++) {
            factory(Ad::class)->create([
                'section_id' => $i,
                'city_id' => $faker->numberBetween(1, 365),
                'type' => 'business',
                'featured' => false,
                'created_at' => now()->subMinutes(5)
            ]);
        }
    }
}
