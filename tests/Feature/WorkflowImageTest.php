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

        $this->assertNotEmpty(file_get_contents($workflow->asset('300x200.jpg')));
        $this->assertNotEmpty(file_get_contents($workflow->asset('600x325.jpg')));
        $this->assertNotEmpty(file_get_contents($workflow->asset('900x300.jpg')));
    }
}
