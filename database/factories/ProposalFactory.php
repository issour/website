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

$factory->state(Proposal::class, 'with-email', function (Faker $faker) {
    return [
        'email' => $faker->email,
    ];
});

$factory->state(Proposal::class, 'approved', function (Faker $faker) {
    return [
        'approved_at' => now()->subDays(rand(1, 30)),
    ];
});

$factory->state(Proposal::class, 'rejected', function (Faker $faker) {
    return [
        'rejected_at' => now()->subDays(rand(1, 30)),
    ];
});
