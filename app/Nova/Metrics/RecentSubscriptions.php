<?php

namespace App\Nova\Metrics;

use App\Nova\Subscription;
use NovaListCard\ListCard;

class RecentSubscriptions extends ListCard
{
    /**
     * Setup the card options
     */
    public function __construct()
    {
        $this->resource(Subscription::class)
            ->heading('Recent Subscriptions')
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
        return 'recent-subscriptions';
    }
}
