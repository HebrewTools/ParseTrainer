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

Route::group(
	[
		'prefix' => parse_url(env('APP_URL'), PHP_URL_PATH),
	],
	function () {

		Route::get('/', function () {
			return view('trainer');
		});

		Route::get('/stem', function () {
			return \HebrewParseTrainer\Stem::all();
		});

		Route::get('/tense', function () {
			return \HebrewParseTrainer\Tense::all();
		});

		Route::get('/verb/random',
			'\App\Http\Controllers\VerbController@random');

		Route::get('/contribute', function () {
			return view('contribute');
		});

		Route::group(['middleware' => 'auth'], function () {
			Route::get('/stats', function () {
				return view('stats');
			});

			Route::get('/verb/{id}/vote/{choice}',
				'\App\Http\Controllers\VerbController@vote');

			Route::post('/verb/suggest',
				'\App\Http\Controllers\VerbController@suggest');

			Route::post('/root/create',
				'\App\Http\Controllers\RootController@create');

		});

});

Auth::routes();
