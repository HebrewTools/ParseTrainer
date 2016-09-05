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

class VerbAction extends Model {

	protected $table = 'verb_actions';
	public $timestamps = false;
	protected $dates = ['date'];
	protected $fillable = ['user_id', 'verb_id', 'kind', 'vote_weight', 'comment_text'];

	const KIND_SUGGEST = 1;
	const KIND_VOTE = 2;

	public function verb() {
		return $this->belongsTo('HebrewParseTrainer\Verb');
	}

	public function user() {
		return $this->belongsTo('HebrewParseTrainer\User');
	}

}
