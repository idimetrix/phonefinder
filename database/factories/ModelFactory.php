<?php

use App\Models\Phone;

$factory->define(App\Models\Like::class, function (Faker\Generator $faker) {
    return [
        'phoneId' => $faker->randomElement(Phone::query()->pluck('id')->toArray()),
        'value' => $faker->randomElement(['-1', '1']),
        'ip' => $faker->ipv4,
        'agent' => $faker->userAgent,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
      'name' => $faker->name,
      'email' => $faker->unique()->safeEmail,
      'password' => bcrypt('secret'),
      'remember_token' => str_random(10),
    ];
});

$factory->define(Phone::class, function (Faker\Generator $faker) {
    $phone = explode('x', $faker->phoneNumber) [0];

    return [
      'number' => $phone,
      'prefix' => $faker->numberBetween(0, 10),
      'country' => 'AD',
      'aliases' => "+$phone|tel:+$phone",
      'url' => '',
      'page' => $faker->numberBetween(1, 1000),
    ];
});
$factory->define(App\Models\View::class, function (Faker\Generator $faker) {

    return [
        'phoneId' => $faker->randomElement(Phone::query()->pluck('id')->toArray()),
        'count' => $faker->numberBetween(1, 1000),
        'ip' => $faker->ipv4,
        'agent' => $faker->userAgent,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});


