<?php
/**
 * HebrewParseTrainer - practice Hebrew verbs
 * Copyright (C) 2015  Camil Staps <info@camilstaps.nl>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

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

$app->group(['prefix' => parse_url(env('APP_URL'), PHP_URL_PATH)], function ($app) {
    
    $app->get('/', function () use ($app) {
        return view('trainer');
    });
    
    $app->get('/stem', function () use ($app) {
        return \HebrewParseTrainer\Stem::all();
    });
    
    $app->get('/tense', function () use ($app) {
        return \HebrewParseTrainer\Tense::all();
    });
    
    $app->get('/verb/random', 'App\Http\Controllers\RandomVerbController@show');

    $app->get('/stats', function () use ($app) {
        return view('stats');
    });
    
});
