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
$faker = Faker\Factory::create('zh_CN');

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

$factory->define(tecai\Models\Organization\Corporation::class, function () use ($faker) {
    $legal_person_id = mt_rand(1, 1000);

    $tags = \tecai\Models\Common\Tag::take(100)->get(['id','name']);
    $tag_name = [];
    $tag_id = [];
    foreach( $tags as $tag) {
        $tag_name[] = $tag->name;
    }
    $num = mt_rand(1, count($tag_name));
    $keys = array_rand($tag_name, $num);

    $tag_name = implode(',', array_map(function($key) use ($tag_name) {
        return $tag_name[$key];
    }, $keys));

    $tag_id = implode(',', array_map(function($key) {
        return $key;
    }, $keys));
//    exit;
    return [
        'legal_person_id' => $legal_person_id,
        'legal_person_name' => 'John' . $legal_person_id,
        'name' => 'JC company' . $legal_person_id,
        'logo_img' => 'logopic',
        'city' => $faker->city,
        'address' => $faker->address,
        'business' => '高新科技' . $legal_person_id,
        'tag_name' => $tag_name,
        'tag_id' => $tag_id,
    ];
});

