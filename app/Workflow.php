<?php

namespace App;

use Illuminate\Support\Arr;
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

    public function updateGithubData()
    {
        $opts = ['http' => ['method' => 'GET','header' => ['User-Agent: PHP']]];

        $context = stream_context_create($opts);
        $results = json_decode(file_get_contents("https://api.github.com/repos/$this->repository", false, $context), true);

        return $this->update([
            'stars' => Arr::get($results, 'stargazers_count', 0),
            'issues' => Arr::get($results, 'open_issues', 0),
        ]);
    }

    public function app()
    {
        return $this->belongsTo(App::class);
    }
}
