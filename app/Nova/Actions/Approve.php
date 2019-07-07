<?php

namespace App\Nova\Actions;

use App\App;
use App\Jobs\ApproveProposal;
use Illuminate\Bus\Queueable;
use Laravel\Nova\Fields\Text;
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

        $proposal->update(['approved_at' => now()]);

        dispatch(new CreateRepository($proposal, $fields->toArray()));
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Select::make('App')
                ->options(App::all()->pluck('title', 'id'))
                ->rules('required'),

            Text::make('Repository')
                ->rules('required', 'alpha_dash')
                ->help('ie gmail-outcome'),
        ];
    }
}
