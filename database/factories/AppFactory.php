<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\App;
use Faker\Generator as Faker;

$factory->define(App::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'image' => 'htts://placehold.it/400x300',
        'blurb' => $faker->words(10, true),
    ];
});
