<?php

namespace App\Observers;

class VoteObserver
{
    public function creating($vote)
    {
        $vote->workflow->increment('votes');
    }
}
