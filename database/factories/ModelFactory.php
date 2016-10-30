<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(tecai\Models\User\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(tecai\Models\Common\Tag::class, function () use ($faker){
    return [
        'type' => mt_rand(1, 2) == 1 ? \tecai\Models\Common\Tag::Organization : \tecai\Models\Common\Tag::User,
        'name' => $faker->colorName
    ];
});