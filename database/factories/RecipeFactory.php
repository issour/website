<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Recipe;
use App\Workflow;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Recipe::class, function (Faker $faker) {
    return [
        'title' => $faker->words(5, true),
        'markdown' => $faker->paragraphs(3, true),
        'workflow_id' => factory(Workflow::class),
    ];
});
