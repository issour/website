<?php

namespace App;

use App\Workflow;
use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    public function workflows()
    {
        return $this->hasMany(Workflow::class);
    }
}
