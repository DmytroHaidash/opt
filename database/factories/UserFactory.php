<?php

/** @var Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

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

$factory->define(User::class, function (Faker $faker) {
    $phoneCodes = ['066', '067', '068', '095', '096', '098', '039', '063', '097', '073'];

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => \Str::random(10),
        'phone' => '38 '
            . $phoneCodes[array_rand($phoneCodes, 1)] . ' '
            . sprintf("%03d", $faker->randomNumber(3)) . ' '
            . sprintf("%02d", $faker->randomNumber(2)) . ' '
            . sprintf("%02d", $faker->randomNumber(2)),
        'city_id' => rand(1, 4)
    ];
});
