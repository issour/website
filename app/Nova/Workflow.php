<?php

namespace App\Nova;

use Laravel\Nova\Panel;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class Workflow extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Workflow';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'title'
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
            Text::make('Slug')
                ->rules('required', 'alpha_dash')
                ->creationRules('unique:workflows,slug,{{resourceId}}')
                ->updateRules('unique:workflows,slug,{{resourceId}}')
                ->hideFromIndex(),
            Text::make('Blurb')->rules('required'),
            Textarea::make('Description')->rules('required'),
            Text::make('Repository')->displayUsing(function () {
                return '<a href="https://github.com/'.$this->repository.'" class="no-underline font-bold dim text-primary" target="_blank">'.$this->repository.'</a>';
            })->rules('required')->hideFromIndex()->asHtml(),
            Number::make('Stars')->onlyOnDetail(),
            Number::make('Issues')->onlyOnDetail(),
            BelongsTo::make('App'),
            DateTime::make('Published At'),

            (new Panel('Import', [
                Text::make('Outcome')->hideFromIndex(),
                KeyValue::make('Options'),
            ])),

            (new Panel('Images', [
                Image::make('Icon')->hideFromIndex(),
                Image::make('Image')->hideFromIndex(),
                Image::make('Banner')->hideFromIndex(),
            ])),
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
        return [];
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
        return [];
    }
}
