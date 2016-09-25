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

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model implements Authenticatable, CanResetPassword {

	use CanResetPasswordTrait;
	use Notifiable;

	protected $table = 'users';
	public $timestamps = false;
	protected $fillable = ['email', 'name', 'isadmin'];

	const VOTE_WEIGHT_BASE = 5;

	public function changePoints($kind, $change, $verb = null) {
		$change = new PointChange;
		$change->user = $this->id;
		$change->change = $change;
		$change->kind = $kind;
		$change->verb = is_null($verb) ? null : $verb->id;
		$change->save();
		
		$this->points += $change;
		$this->save();
	}

	public function voteWeight() {
		if ($this->isadmin)
			return Verb::ACCEPTED_VOTE_COUNT;

		if ($this->points <= 0)
			return 0;

		return floor(log($this->points, self::VOTE_WEIGHT_BASE));
	}

	public function verifyPassword($pass) {
		if (!Hash::check($pass, $this->password))
			return false;

		if (Hash::needsRehash($this->password)) {
			$this->password = $pass;
			$this->save();
		}

		return true;
	}

	public function getAuthIdentifierName() {
		return $this->email;
	}

	public function getAuthIdentifier() {
		return $this->id;
	}

	public function getAuthPassword() {
		return $this->password;
	}

	public function getRememberToken() {
		return $this->remember_token;
	}

	public function setRememberToken($token) {
		$this->remember_token = $token;
		$this->save();
	}

	public function getRememberTokenName() {
		return 'remember_token';
	}

}
