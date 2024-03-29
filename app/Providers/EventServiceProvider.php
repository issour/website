<?php

namespace App\Providers;

use App\Vote;
use App\Recipe;
use App\Workflow;
use App\Observers\VoteObserver;
use App\Observers\RecipeObserver;
use App\Observers\WorkflowObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Workflow::observe(WorkflowObserver::class);
        Recipe::observe(RecipeObserver::class);
        Vote::observe(VoteObserver::class);
    }
}
