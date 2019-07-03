<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\App;
use App\Workflow;
use Faker\Generator as Faker;

$factory->define(Workflow::class, function (Faker $faker) {
    return [
        'title' => $faker->bs,
        'blurb' => $faker->text,
        'description' => $faker->text,
        'repository' => "https://github.com/{$faker->username}/{$faker->domainWord}",
        'published_at' => now()->addDays(rand(0, 50)),
        'icon' => 'https://placehold.it/24x24&text=icon',
        'image' => 'https://placehold.it/300x250&text=image',
        'banner' => 'https://placehold.it/900x350&text=banner',
        'app_id' => factory(App::class),
    ];
});
