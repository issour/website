<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    public static function bySlug($slug)
    {
        return self::where('slug', $slug)->firstOrFail();
    }

    public function fillSlugUsing($column)
    {
        $attempt = 1;

        $slug = Str::slug($this->$column);

        $this->slug = $slug;

        while (\DB::table($this->getTable())->where('slug', '=', $slug)->exists()) {
            $slug = $this->slug . '-' . ++$attempt;
        }

        $this->slug = $slug;
    }
}
