<?php

use App\App;
use App\Recipe;
use App\Proposal;
use App\Workflow;
use App\Subscription;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        app()['env'] = 'seeding';

        Subscription::truncate();
        Workflow::truncate();
        Proposal::truncate();
        Recipe::truncate();
        App::truncate();

        factory(Workflow::class, 100)->state('live')->create();
        factory(Workflow::class, 100)->state('staging')->create();
        factory(Proposal::class, 100)->create();
        factory(Recipe::class, 100)->create();
        factory(Subscription::class, 100)->state('workflow')->create();
        factory(Subscription::class, 100)->create();
    }
}
