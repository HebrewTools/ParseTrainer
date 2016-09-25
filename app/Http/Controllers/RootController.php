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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use HebrewParseTrainer\Root;
use HebrewParseTrainer\RootKind;

class RootController extends Controller {

	public function create(Request $request) {
		$_kinds = RootKind::all();
		$kinds = [];
		foreach ($_kinds as $kind)
			$kinds[] = $kind->id;

		$validator = Validator::make($request->input(), [
			'root'         => 'required',
			'root_kind_id' => 'in:' . implode(',', $kinds),
		]);

		if ($validator->fails()) {
			return [
				'success' => false,
				'message' => $validator->errors()->first()
			];
		}

		$root = new Root;
		$root->root = $request->input('root');
		$root->root_kind_id = $request->input('root_kind_id');
		$root->save();

		return [
			'success' => true,
		];
	}

}
