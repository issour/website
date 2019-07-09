<?php

namespace Tests\Feature;

use App\Recipe;
use App\Workflow;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecipeTest extends TestCase
{
    public function testViewingRecipesOnWorkflow()
    {
        $workflow = factory(Workflow::class)->state('live')->create();

        $recipes = factory(Recipe::class, 5)->create(['workflow_id' => $workflow->id]);

        $response = $this->get('/workflows/' . $workflow->slug);

        $response->assertStatus(200);

        $response->assertViewHas('recipes', function ($results) use ($recipes) {
            return $results->pluck('id')->diff($recipes->pluck('id'))->isEmpty();
        });

        $response->assertSee($recipes->first()->title);
        $response->assertSee(route('recipes.show', $recipes->first()->slug));
    }

    public function testViewingSingleRecipe()
    {
        $workflow = factory(Workflow::class)->state('live')->create();

        $recipes = factory(Recipe::class, 5)->create(['workflow_id' => $workflow->id]);

        $response = $this->get('/recipes/' . $recipes->first()->slug);

        $response->assertStatus(200);

        $response->assertViewHas('workflow', function ($w) use ($workflow) {
            return $w->id ==  $workflow->id;
        })->assertViewHas('recipe', function ($r) use ($recipes) {
            return $r->id == $recipes->first()->id;
        });

        $response->assertSee($recipes->first()->title);
        $response->assertSee($recipes->first()->content);
        $response->assertSee(route('workflows.show', $workflow->slug));
        $response->assertSee($workflow->app->title);
    }

    public function testSameTitleProducesDifferentSlugs()
    {
        $recipe_1 = factory(Recipe::class)->create();
        $recipe_2 = factory(Recipe::class)->create(['title' => $recipe_1->title]);
        $recipe_3 = factory(Recipe::class)->create(['title' => $recipe_1->title]);

        $this->assertFalse($recipe_1->slug == $recipe_2->slug);
        $this->assertTrue($recipe_2->slug == $recipe_1->slug . '-2');
        $this->assertTrue($recipe_3->slug == $recipe_1->slug . '-3');
    }
}
