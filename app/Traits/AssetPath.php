<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait AssetPath
{
    public function path($file='')
    {
        return storage_path("app/public/{$this->repository}/$file");
    }

    public function asset($file)
    {
        return asset("{$this->repository}/$file");
    }
}
