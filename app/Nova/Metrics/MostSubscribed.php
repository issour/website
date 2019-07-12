<?php

namespace App\Nova\Metrics;

use App\Nova\User;
use App\Nova\Workflow;
use NovaListCard\ListCard;

class MostSubscribed extends ListCard
{
    /**
     * Setup the card options
     */
    public function __construct()
    {
        $this->resource(Workflow::class)
            ->heading('Most Subscribed')
            ->withCount('subscribers')
            ->value('subscribers_count')
            ->viewAll();
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'most-subscribed';
    }
}
