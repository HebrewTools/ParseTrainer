<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return view('trainer');
});

$app->get('/stem', function () use ($app) {
    return \HebrewParseTrainer\Stem::all();
});

$app->get('/tense', function () use ($app) {
    return \HebrewParseTrainer\Tense::all();
});

$app->get('/verb/random', 'RandomVerbController@show');
