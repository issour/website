<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    public $with = ['app'];

    public $casts = [
        'published_at' => 'datetime',
    ];

    public function scopeFiltered($query)
    {
        $query->when(request('search'), function ($query, $term) {
            $query->whereHas('app', function ($query) use ($term) {
                $query->where('title', 'LIKE', "%$term%");
            })->orWhere('title', 'LIKE', "%$term%");
        })->latest();
    }

    public static function bySlug($slug)
    {
        return self::where('slug', $slug)->firstOrFail();
    }

    public function app()
    {
        return $this->belongsTo(App::class);
    }
}
