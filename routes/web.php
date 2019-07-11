<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('workflows', 'WorkflowController@index')->name('workflows.index');
Route::get('workflows/{slug}', 'WorkflowController@show')->name('workflows.show');
Route::get('staging', 'StagingController@index')->name('staging.index');
Route::get('import/workflows/{id}.json', 'ImportController@show')->name('imports.show');
Route::get('recipes/{slug}', 'RecipeController@show')->name('recipes.show');

Route::get('login/github', 'LoginController@redirect')->name('login');
Route::get('login/github/callback', 'LoginController@callback');

Route::get('new', 'ProposalController@create');
Route::post('new', 'ProposalController@store');

Route::middleware('auth')->group(function () {
    Route::post('votes/{id}', 'VoteController@store')->name('votes.store');
});

Route::post('subscribe', 'SubscriptionController@store')->name('subscription.store');
Route::get('unsubscribe', 'SubscriptionController@edit')->name('subscription.edit');
Route::delete('unsubscribe', 'SubscriptionController@destroy')->name('subscription.destroy');
