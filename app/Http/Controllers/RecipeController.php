<?php

namespace App\Http\Controllers;

use App\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function show($slug)
    {
        $recipe = Recipe::bySlug($slug);

        return view('recipes.show', [
            'workflow' => $recipe->workflow,
            'recipe' => $recipe,
        ]);
    }
}
