<?php

namespace Tests\Feature;

use App\Workflow;
use Tests\TestCase;
use App\Jobs\GenerateImages;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkflowImageTest extends TestCase
{
    use RefreshDatabase;

    public function testGeneratingImages()
    {
        $workflow = factory(Workflow::class)->states('live', 'with-logo')->create();

        dispatch(new GenerateImages($workflow->repository));

        $this->assertFileExists($workflow->path('300x200.jpg'));
        $this->assertFileExists($workflow->path('600x325.jpg'));
        $this->assertFileExists($workflow->path('900x300.jpg'));

        $this->assertFileIsReadable($workflow->path('300x200.jpg'));
        $this->assertFileIsReadable($workflow->path('600x325.jpg'));
        $this->assertFileIsReadable($workflow->path('900x300.jpg'));

        tap($workflow->fresh(), function ($workflow) {
            $this->assertEquals($workflow->relativePath('300x200.jpg'), $workflow->image);
            $this->assertEquals($workflow->relativePath('600x325.jpg'), $workflow->og_twitter_image);
            $this->assertEquals($workflow->relativePath('900x300.jpg'), $workflow->banner);
        });
    }
}
