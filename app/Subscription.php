<?php

namespace App;

use App\Workflow;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Subscription extends Model
{
    use Notifiable;

    public function scopeGeneral($query)
    {
        $query->whereNull('workflow_id');
    }

    public function scopeWorkflows($query)
    {
        $query->whereNotNull('workflow_id');
    }

    public function workflow()
    {
        return $this->belongsTo(Workflow::class);
    }
}
