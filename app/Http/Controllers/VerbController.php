<?php
/**
 * HebrewParseTrainer - practice Hebrew verbs
 * Copyright (C) 2015-2023  Camil Staps <info@camilstaps.nl>
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

use HebrewParseTrainer\PointChange;
use HebrewParseTrainer\Stem;
use HebrewParseTrainer\Tense;
use HebrewParseTrainer\Verb;
use HebrewParseTrainer\VerbAction;
use HebrewParseTrainer\RandomLog;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as RequestFacade;
use Illuminate\Support\Facades\Validator;

class VerbController extends Controller {

	public function random() {
		if (date('N') == 5) {
			return response()->json(['message' => 'The app is disabled on Fridays due to lack of donations. Please consider <a href="https://whydonate.com/donate/hebrewtools-donations" target="_blank">donating</a> for the upkeep of the server: we need less than €10/month.'], status: 503);
		}

		$verbs = Verb::where('active', 1);
		foreach (RequestFacade::input() as $col => $val) {
			if ($col == '_token')
				continue;
			if (!in_array($col, ['stem', 'tense', 'root'])) {
				return response()->json(['message' => 'Malformed request.'], status: 403);
			}
			$vals = explode(',', $val);
			$verbs = $verbs->whereIn($col, $vals);
		}
		$verbs = $verbs->get();

		if ($verbs->count() == 0) {
			return response()->json(['message' => 'There are no verbs matching the criteria in our database.'], status: 404);
		}

		$verb = $verbs->random();

		/* Possible answers are taken from the filtered verbs. Previously answers
		 * were *all* entries in the database with the same form. This was
		 * problematic in cases like נִקְטֹל. If a user has filtered to only train qal
		 * forms, they should not be discouraged by the system saying this is also
		 * a niphal infinitive absolute. */
		$answers = $verbs->filter(function ($v) use ($verb) {
			return $v->verb === $verb->verb;
		});

		$log = new RandomLog();
		$log->request = json_encode(RequestFacade::input());
		$log->response = $verb->id;
		$log->ip = $_SERVER['REMOTE_ADDR'];
		$log->save();

		$obj = ['verb' => $verb, 'answers' => $answers];
		return response()->json($obj);
	}

	public function suggest(Request $request) {
		$_tenses = Tense::all();
		$tenses = [];
		foreach ($_tenses as $tense)
			$tenses[] = $tense->name;

		$_stems = Stem::all();
		$stems = [];
		foreach ($_stems as $stem)
			$stems[] = $stem->name;

		$validator = Validator::make($request->input(), [
			'verb'   => 'required',
			'root'   => 'required',
			'stem'   => 'in:' . implode(',', $stems),
			'tense'  => 'in:' . implode(',', $tenses),
			'person' => 'in:,1,2,3',
			'gender' => 'in:,m,f',
			'number' => 'in:,s,p',
		]);

		if ($validator->fails()) {
			return [
				'success' => false,
				'message' => $validator->errors()->first()
			];
		}

		$verb = new Verb;
		$verb->verb = $request->input('verb');
		$verb->root = $request->input('root');
		$verb->stem = $request->input('stem');
		$verb->tense = $request->input('tense');
		$verb->person = $request->input('person') ? $request->input('person') : null;
		$verb->gender = $request->input('gender') ? $request->input('gender') : null;
		$verb->number = $request->input('number') ? $request->input('number') : null;
		$verb->active = 0;
		$verb->save();

		$action = new VerbAction;
		$action->kind = VerbAction::KIND_SUGGEST;
		$action->user_id = Auth::user()->id;
		$action->verb_id = $verb->id;
		$action->save();

		$this->vote(1, $verb->id);

		return [
			'success' => true,
			'id' => $verb->id,
			'accepted' => $verb->active != 0
		];
	}

	protected function checkAccept($verb) {
		if ($verb->voteCount() < Verb::ACCEPTED_VOTE_COUNT)
			return false;

		$verb->active = 1;
		$verb->save();

		if (!is_null($user = $verb->suggestedBy())) {
			$ptchange = new PointChange;
			$ptchange->kind = PointChange::KIND_SUGGESTION_ACCEPTED;
			$ptchange->change = PointChange::POINTS_SUGGESTION_ACCEPTED;
			$ptchange->user_id = $user->id;
			$ptchange->verb_id = $verb->id;
			$ptchange->save();

			$user->points += PointChange::POINTS_SUGGESTION_ACCEPTED;
			$user->save();
		}

		return true;
	}

	public function vote($verb_id, $choice) {
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

		$accepted = $this->checkAccept($verb);

		return [
			'success' => true,
			'vote_weight' => $user->voteWeight(),
			'accepted' => $accepted,
			'new_vote_count' => $verb->voteCount()
		];
	}

}
