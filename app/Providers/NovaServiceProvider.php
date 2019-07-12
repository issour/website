<?php

namespace App\Providers;

use Laravel\Nova\Nova;
use App\Nova\Metrics\MostVoted;
use App\Nova\Metrics\RecentVotes;
use App\Nova\Metrics\MostSubscribed;
use Illuminate\Support\Facades\Gate;
use App\Nova\Metrics\OldestProposals;
use App\Nova\Metrics\RecentProposals;
use App\Nova\Metrics\CountVotesCreated;
use App\Nova\Metrics\RecentSubscriptions;
use App\Nova\Metrics\CountProposalsCreated;
use App\Nova\Metrics\CountSubscriptionsCreated;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the cards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            new CountProposalsCreated,
            new CountSubscriptionsCreated,
            new CountVotesCreated,
            new RecentProposals,
            new RecentSubscriptions,
            new RecentVotes,
            new MostVoted,
            new MostSubscribed,
            new OldestProposals,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
