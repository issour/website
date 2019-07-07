<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    public $appends = ['status'];

    public function getStatusAttribute()
    {
        if ($this->approved_at) {
            return 'approved';
        }

        if ($this->rejected_at) {
            return 'rejected';
        }

        return 'requested';
    }
}
