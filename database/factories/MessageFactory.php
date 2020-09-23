<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Ad;
use App\User;
use App\Message;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {
    return [
        'creator_id' => function () {
            return factory(User::class)->create()->id;
        },
        'ad_id' => function () {
            return factory(Ad::class)->create()->id;
        },
        'parent_message_id' => null,
        'recipient_id' => function () {
            return factory(User::class)->create()->id;
        },
        'subject' => $faker->sentence,
        'body' => $faker->paragraph
    ];
});
