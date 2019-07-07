<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\WorkflowRequest;
use Faker\Generator as Faker;

$factory->define(WorkflowRequest::class, function (Faker $faker) {
    return [
        'title' => $faker->bs,
        'description' => $faker->paragraph,
        'url' => $faker->url,
    ];
});
