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
namespace HebrewParseTrainer;

use Illuminate\Database\Eloquent\Model;

class Verb extends Model {

	protected $table = 'verbs';
	public $timestamps = false;
	protected $fillable = ['verb', 'root', 'stem', 'tense', 'person', 'gender', 'number'];

	const ACCEPTED_VOTE_COUNT = 5;

	public function actions() {
		return $this->hasMany('HebrewParseTrainer\VerbAction');
	}

	public function otherParsings() {
		return self::where('verb', $this->verb)->get()
			->filter(function($v){return $v->verb === $this->verb;});
	}

	public function voteCount() {
		$votes = $this->actions()->where('kind', VerbAction::KIND_VOTE)->get();
		$total = 0;
		foreach ($votes as $vote)
			$total += $vote->vote_weight;
		return $total;
	}

	public function userVote(User $user) {
		$votes = $this->actions()
			->where('kind', VerbAction::KIND_VOTE)
			->where('user_id', $user->id)
			->get();
		foreach ($votes as $vote) {
			return $vote->vote_weight;
		}
		return 0;
	}

	public function suggestedBy() {
		$suggs = $this->actions()
			->where('kind', VerbAction::KIND_SUGGEST)
			->get();

		foreach ($suggs as $sugg) {
			return $sugg->user;
		}

		return null;
	}

}
