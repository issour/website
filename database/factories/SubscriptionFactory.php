<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Workflow;
use App\Subscription;
use Faker\Generator as Faker;

$factory->define(Subscription::class, function (Faker $faker) {
    return [
        'email' => $faker->email,
    ];
});

$factory->state(Subscription::class, 'workflow', function ($faker) {
    return [
        'workflow_id' => factory(Workflow::class),
    ];
});
