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

        if (!file_exists($workflow->path('logo.png'))) {
            abort(500, 'Logo required to create images');
        }

        $smallLogo = Image::make($workflow->path('logo.png'))
            ->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            });

        Image::make(resource_path('graphics/300x200.jpg'))
            ->insert($smallLogo, 'center')
            ->save($workflow->path('300x200.jpg'), 100);

        Image::make(resource_path('graphics/600x325.jpg'))
            ->insert($smallLogo, 'center')
            ->text("Laravel & " . $workflow->app->title, 120, 100, function ($font) {
                $font->file($this->fontFile());
                $font->color('#ffffff');
                $font->align('center');
                $font->size(32);
            })->save($workflow->path('600x325.jpg'), 100);

        Image::make(resource_path('graphics/900x300.jpg'))
            ->insert($smallLogo, 'center')
            ->text("Laravel & " . $workflow->app->title, 120, 100, function ($font) {
                $font->file($this->fontFile());
                $font->color('#ffffff');
                $font->align('center');
                $font->size(48);
            })->save($workflow->path('900x300.jpg'), 100);

        Image::make($smallLogo)->save($workflow->path('logo-sm.jpg'), 100);

        $workflow->update([
            'image' => $workflow->relativePath('300x200.jpg'),
            'banner' => $workflow->relativePath('900x300.jpg'),
            'og_twitter_image' => $workflow->relativePath('600x325.jpg'),
        ]);
    }

    protected function fontFile()
    {
        return resource_path('fonts/open-sans/bold.ttf');
    }
}
