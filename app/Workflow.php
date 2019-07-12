<?php

namespace App;

use App\User;
use App\Subscription;
use App\Traits\HasSlug;
use Illuminate\Support\Arr;
use App\Traits\RepositoryAssets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Workflow extends Model
{
    use HasSlug, RepositoryAssets;

    public $with = ['app'];

    public $appends = ['status'];

    public $casts = [
        'options' => 'array',
        'staged_at' => 'datetime',
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

    public function scopePublished($query)
    {
        $query->whereNotNull('published_at');
        $query->where('published_at', '<=', now());
    }

    public function scopeStaging($query)
    {
        $query
            ->withoutGlobalScope(Published::class)
            ->whereNull('published_at')
            ->whereNotNull('staged_at');
    }

    public function inStaging()
    {
        return $this->status != 'published';
    }

    public function isPublished()
    {
        return $this->status == 'published';
    }

    public function getStatusAttribute()
    {
        return is_null($this->published_at) ? 'staging' : 'published';
    }

    public function storeImport()
    {
        $properties = Arr::only($this->toArray(), ['title', 'outcome', 'options']);

        file_put_contents($this->path('import.json'), json_encode($properties));
    }

    public function youtubeEmbedUrl()
    {
        return 'https://www.youtube.com/embed/' . Arr::get(explode('?v=', $this->youtube), 1);
    }

    public function getTweetTextAttribute()
    {
        $emoji = ['🔥', '🚀'][rand(0, 1)];

        $prefix = ($this->inStaging())
            ? ['WIP', 'Coming soon', 'Upcoming'][rand(0, 2)]
            : ['Checkout', 'Looks cool', 'Woohoo'][rand(0, 2)];

        return  "$emoji $prefix: {$this->title} using Laravel Nova";
    }

    public function authVote()
    {
        return optional(auth()->user())->getVoteFor($this);
    }

    public function app()
    {
        return $this->belongsTo(App::class);
    }

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function voters()
    {
        return $this->belongsToMany(User::class, 'votes')->withTimestamps();
    }

    public function subscribers()
    {
        return $this->hasMany(Subscription::class);
    }
}
