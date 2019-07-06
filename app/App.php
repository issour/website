<?php

namespace App;

use App\Workflow;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    use HasSlug;

    public function workflows()
    {
        return $this->hasMany(Workflow::class);
    }
}
