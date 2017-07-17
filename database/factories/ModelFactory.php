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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
$factory->define(App\VisitFlow::class, function (Faker\Generator $faker) {
    return [
        'time' => $faker->dateTimeThisYear($max = 'now', $timezone = date_default_timezone_get())
    ];
});
$factory->define(App\Article::class, function (Faker\Generator $faker) {
    return [
        'title'=>$faker->title,
        'body'=>$faker->text($maxNbChars = 200) ,
        'if_draft'=>$faker->randomElement($array = [0,1]),
        'outline'=>$faker->sentence($nbWords = 6, $variableNbWords = true)
    ];
});
$factory->define(App\Category::class, function (Faker\Generator $faker) {
    return [
        'name'=>$faker->name,
        'type'=>$faker->randomElement($array = [0,1])
    ];
});
