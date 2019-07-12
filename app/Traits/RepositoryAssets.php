<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait RepositoryAssets
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

    public function relativePath($file)
    {
        $prefix = (app()->environment('testing')) ? 'testing' : '';

        return "/$prefix/{$this->repository}/$file";
    }
}
