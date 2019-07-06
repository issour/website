<?php

namespace App;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasSlug;

    public function workflow()
    {
        return $this->belongsTo(Workflow::class);
    }
}
