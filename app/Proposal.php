<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    public $appends = ['status'];

    public $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

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

    public function app()
    {
        return $this->belongsTo(App::class);
    }
}
