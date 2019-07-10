<?php

namespace App\Jobs;

use App\Workflow;
use Illuminate\Bus\Queueable;
use Intervention\Image\Facades\Image;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateImages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function handle()
    {
        $workflow = Workflow::where('repository', $this->repository)->firstOrFail();

        abort_if(!file_exists($workflow->path('logo.png')), 500, 'Logo required to create images');

        Image::make(resource_path('graphics/300x200.jpg'))
            ->insert($workflow->path('logo.png'), 'center')
            ->text($workflow->app->title, 120, 100)
            ->save($workflow->path('300x200.jpg'), 100);

        Image::make(resource_path('graphics/600x325.jpg'))
            ->insert($workflow->path('logo.png'), 'center')
            ->text($workflow->app->title, 120, 100)
            ->save($workflow->path('600x325.jpg'), 100);

        Image::make(resource_path('graphics/900x300.jpg'))
            ->insert($workflow->path('logo.png'), 'center')
            ->text($workflow->app->title, 120, 100)
            ->save($workflow->path('900x300.jpg'), 100);
    }
}
