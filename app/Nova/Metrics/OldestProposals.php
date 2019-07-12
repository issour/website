<?php

namespace App\Nova\Metrics;

use App\Nova\User;
use App\Nova\Proposal;
use NovaListCard\ListCard;

class OldestProposals extends ListCard
{
    /**
     * Setup the card options
     */
    public function __construct()
    {
        $this->resource(Proposal::class)
            ->heading('Oldest Proposals')
            ->orderBy('created_at')
            ->value('created_at', 'MM/DD/YY', 'timestamp')
            ->viewAll();
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'oldest-proposals';
    }
}
