<?php

namespace App\Nova\Metrics;

use App\Nova\Vote;
use NovaListCard\ListCard;

class RecentVotes extends ListCard
{
    /**
     * Setup the card options
     */
    public function __construct()
    {
        $this->resource(Vote::class)
            ->heading('Recent Votes')
            ->subtitle()
            ->limit(3)
            ->viewAll();
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'recent-votes';
    }
}
