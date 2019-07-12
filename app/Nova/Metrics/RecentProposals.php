<?php

namespace App\Nova\Metrics;

use App\Nova\Proposal;
use NovaListCard\ListCard;

class RecentProposals extends ListCard
{
    /**
     * Setup the card options
     */
    public function __construct()
    {
        $this->resource(Proposal::class)
            ->heading('Recent Proposals')
            ->timestamp()
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
        return 'recent-proposals';
    }
}
