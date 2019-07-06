<?php

namespace App\Observers;

use Illuminate\Support\Str;
use Illuminate\Mail\Markdown;

class RecipeObserver
{
    public function saving($recipe)
    {
        $recipe->content = Markdown::parse($recipe->markdown);

        $recipe->fillSlugUsing('title');
    }
}
