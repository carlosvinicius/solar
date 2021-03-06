<?php

use Faker\Generator as Faker;

use App\Models\OneDayElectricity;
use App\Models\OneHourElectricity;
use App\Models\Panel;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Panel::class, function (Faker $faker) {
    return [
        'serial' => str_random(15),
        'longitude' => $faker->longitude,
        'latitude' => $faker->latitude
    ];
});

$factory->define(OneHourElectricity::class, function (Faker $faker) {
    return [
        'panel_id' => $faker->randomDigit,
        'kilowatts' => $faker->randomDigit,
        'hour' => \DateTime::createFromFormat('Y-m-d H:i:s', $faker->dateTime->format('Y-m-d H:00:00'))
    ];
});

$factory->define(OneDayElectricity::class, function (Faker $faker) {
    return [
        'panel_id' => $faker->randomDigit,
        'day'      => $faker->date,
        'sum'      => $faker->randomDigit,
        'min'      => $faker->randomDigit,
        'max'      => $faker->randomDigit,
        'average'  => $faker->randomDigit,
    ];
});
