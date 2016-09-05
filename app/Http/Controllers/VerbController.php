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
use HebrewParseTrainer\VerbAction;
use HebrewParseTrainer\RandomLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;

class VerbController extends BaseController {

	public function random() {
		$verbs = Verb::where('active', 1)->get();
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
		$log->ip = $_SERVER['REMOTE_ADDR'];
		$log->save();

		$obj = ['verb' => $verb, 'answers' => $verb->otherParsings()];
		return response()->json($obj);
	}

	public function vote($choice, $verb_id) {
		$verb = Verb::findOrFail($verb_id);
		$user = Auth::user();

		if ($verb->active)
			return ['success' => false, 'message' => 'This verb has been accepted already.'];

		foreach ($verb->actions()->where('kind', VerbAction::KIND_VOTE)->get() as $vote) {
			if ($vote->user->id == $user->id) {
				$vote->delete();
			}
		}

		$vote = new VerbAction;
		$vote->user_id = $user->id;
		$vote->verb_id = $verb_id;
		$vote->kind = VerbAction::KIND_VOTE;
		$vote->vote_weight = ($choice == 1 ? 1 : -1) * $user->voteWeight();
		$vote->save();

		$message = 'You have voted.';

		if ($verb->voteCount() >= Verb::ACCEPTED_VOTE_COUNT) {
			$verb->active = 1;
			$verb->save();
		}

		return [
			'success' => true,
			'vote_weight' => $user->voteWeight(),
			'accepted' => (bool) $verb->active,
			'new_vote_count' => $verb->voteCount()
		];
	}

}
