<?php

namespace App;

use App\Workflow;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
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
