<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\App;
use App\Workflow;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Workflow::class, function (Faker $faker) {
    return [
        'title' => $faker->bs,
        'slug' => Str::slug($faker->bs),
        'blurb' => $faker->text,
        'description_markdown' => $faker->text,
        'installation_markdown' => $faker->text,
        'repository' => $faker->domainWord,
        'published_at' => null,
        'drafted_at' => now(),
        'outcome' => 'PackageName\\Outcomes\\' . ucwords($faker->word),
        'options' => [
            'to' => '{user.email}',
            'subject' => 'Hi {user.name}, how are you today?',
            'html' => 'Seems like you have spent {user.orders | sum:total} with us',
        ],
        'icon' => 'https://placehold.it/24x24&text=icon',
        'image' => 'https://placehold.it/300x250&text=image',
        'banner' => 'https://placehold.it/900x350&text=banner',
        'app_id' => factory(App::class),
    ];
});
