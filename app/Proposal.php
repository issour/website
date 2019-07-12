<?php

namespace App;

use App\Traits\AssetPath;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Proposal extends Model
{
    use AssetPath, Notifiable;

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
