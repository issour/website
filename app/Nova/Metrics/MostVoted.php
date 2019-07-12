<?php

namespace App\Nova\Metrics;

use App\Nova\Workflow;
use NovaListCard\ListCard;

class MostVoted extends ListCard
{
    /**
     * Setup the card options
     */
    public function __construct()
    {
        $this->resource(Workflow::class)
            ->heading('Most Voted')
            ->value('votes')
            ->orderBy('votes', 'desc')
            ->viewAll();
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'most-voted';
    }
}
