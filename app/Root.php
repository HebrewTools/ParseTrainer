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

class Root extends Model {

	protected $table = 'roots';
	public $timestamps = false;
	protected $fillable = ['root', 'root_kind_id'];

	public function kind() {
		return $this->belongsTo('HebrewParseTrainer\RootKind', 'root_kind_id');
	}

}
