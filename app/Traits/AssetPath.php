<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait AssetPath
{
    public function path($file='')
    {
        $prefix = (app()->environment('testing')) ? 'testing' : '';

        return storage_path("app/public/$prefix/{$this->repository}/$file");
    }

    public function asset($file)
    {
        $prefix = (app()->environment('testing')) ? 'testing' : '';

        return asset("$prefix/{$this->repository}/$file");
    }
}
