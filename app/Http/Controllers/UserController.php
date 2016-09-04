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
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Controller as BaseController;

use HebrewParseTrainer\User;

class UserController extends BaseController {

	public function createForm(Request $request) {
		$messages = [];

		if ($request->isMethod('post')) {
			$validator = Validator::make($request->input(), [
				'email'    => 'required|unique:users|email',
				'name'     => 'required|unique:users',
				'password' => 'required|confirmed|min:8',
			]);

			if ($validator->fails()) {
				foreach ($validator->errors()->all() as $error) {
					$messages[] = ['danger', $error];
				}
			} else {
				$user = new User;
				$user->name = $request->input('name');
				$user->email = $request->input('email');
				$user->password = $request->input('password');
				if ($user->save()) {
					$messages[] = ['success', 'Your account has been created.'];
				} else {
					$messages[] = ['danger', 'Your account could not be created.'];
				}
			}
		}

		return view('user.create',
			[
				'messages' => $messages,
				'form' => [
					'email' => $request->input('email'),
					'name' => $request->input('name')
				]
			]);
	}

}
