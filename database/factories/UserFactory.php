<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    
    $pass = Str::random(10);
    
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $pass,
        'confirm_password' => $pass,
    ];
});
