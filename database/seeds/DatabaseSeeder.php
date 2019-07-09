<?php

use App\App;
use App\Recipe;
use App\Proposal;
use App\Workflow;
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

        Workflow::truncate();
        Proposal::truncate();
        Recipe::truncate();
        App::truncate();

        factory(Workflow::class, 100)->create();
        factory(Proposal::class, 100)->create();
        factory(Recipe::class, 100)->create();
    }
}
