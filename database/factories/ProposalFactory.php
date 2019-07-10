<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Proposal;
use Faker\Generator as Faker;

$factory->define(Proposal::class, function (Faker $faker) {
    return [
        'title' => $faker->bs,
        'description' => $faker->paragraph,
        'url' => $faker->url,
    ];
});

$factory->afterMakingState(Proposal::class, 'with-logo', function ($proposal, $faker) {
    mkdir($proposal->path());
    copy(base_path('tests/Assets/logo.png'), $proposal->path('logo.png'));
});
