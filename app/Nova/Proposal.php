<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use App\Nova\Actions\Reject;
use Illuminate\Http\Request;
use App\Nova\Actions\Approve;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Textarea;
use App\Nova\Filters\ProposalStatus;
use Laravel\Nova\Http\Requests\NovaRequest;

class Proposal extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Proposal';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'title',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Title')->rules('required'),
            Textarea::make('Description')->rules('required'),
            Text::make('Url')->rules('required')->hideFromIndex(),
            Badge::make('Status')->types([
                'requested' => 'bg-20',
                'rejected' => 'bg-danger',
                'approved' => 'bg-success',
            ]),
            DateTime::make('Created At')->exceptOnForms(),
            DateTime::make('Approved At')->onlyOnDetail(),
            DateTime::make('Rejected At')->onlyOnDetail(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new ProposalStatus,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            new Approve,
            new Reject,
        ];
    }
}
