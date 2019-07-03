<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    public $casts = [
        'published_at' => 'datetime',
    ];

    public function scopeFiltered($query)
    {
        $query->when(request('search'), function ($query, $term) {
            $query->where('title', 'LIKE', "%$term%");
        })->latest();
    }
}
