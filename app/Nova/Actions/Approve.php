<?php

namespace App\Nova\Actions;

use App\App;
use App\Jobs\ApproveProposal;
use App\Jobs\ConvertProposal;
use Illuminate\Bus\Queueable;
use Laravel\Nova\Fields\Text;
use App\Jobs\CreateRepository;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Approve extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $onlyOnDetail = true;

    public function handle(ActionFields $fields, Collection $proposals)
    {
        $proposal = $proposals->first();

        abort_if(!is_null($proposal->approved_at), 500, 'Proposal already approved');

        $fields->logo->move(storage_path("app/public/{$fields->repository}"), 'logo.png');

        $proposal->update([
            'app_id' => $fields->app_id,
            'repository' => $fields->repository,
            'stub' => 'stubs/outcome',
            'approved_at' => now(),
        ]);

        dispatch(new ApproveProposal($proposal->fresh()));
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Image::make('Logo')->rules('required', 'mimes:png', 'dimensions:min_width=200,min_height=200'),

            Select::make('App', 'app_id')
                ->options(App::all()->pluck('title', 'id'))
                ->rules('required'),

            Text::make('Repository')
                ->rules('required', 'alpha_dash', 'unique:workflows,repository')
                ->help('ie gmail-outcome'),
        ];
    }
}
