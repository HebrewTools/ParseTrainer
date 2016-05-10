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
namespace App\Http\Controllers;

use HebrewParseTrainer\Verb;
use HebrewParseTrainer\RandomLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Laravel\Lumen\Routing\Controller as BaseController;

class RandomVerbController extends BaseController {

	public function show()
	{
		$verbs = Verb::all();
		foreach (Input::get() as $col => $val) {
			$val = explode(',', $val);
			$verbs = $verbs->filter(function(Verb $item) use ($col, $val) {
				return in_array($item->getAttribute($col), $val);
			});
		}
		$verb = $verbs->random();

		$log = new RandomLog();
		$log->request = json_encode(Input::get());
		$log->response = $verb->id;
		$log->save();

		$obj = ['verb' => $verb, 'answers' => $verb->otherParsings()];
		return response()->json($obj);
	}

}
