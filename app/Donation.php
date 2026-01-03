<?php
/**
 * HebrewParseTrainer - practice Hebrew verbs
 * Copyright (C) 2026  Camil Staps <info@camilstaps.nl>
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

class Donation extends Model {

	protected $table = 'donations';
	public $timestamps = false;
	protected $dates = ['added_at'];
	protected $fillable = ['added_at', 'zapier_guid', 'amount', 'currency', 'amount_eur'];

	const DESIRED_AMOUNT = 9;

	public static function lastMonthAmountEur() {
		$last_month = date_create(date('Y-m-d') . ' first day of last month');
		return static::where('added_at', '>=', $last_month->format('Y-m-d 00:00:00'))
			->where('added_at', '<', date('Y-m-01 00:00:00'))
			->sum('amount_eur');
	}

	public static function thisMonthAmountEur() {
		return static::where('added_at', '>=', date('Y-m-01'))
			->where('added_at', '<=', date('Y-m-t 23:59:59'))
			->sum('amount_eur');
	}

	public static function onTrack() {
		return static::lastMonthAmountEur() >= static::DESIRED_AMOUNT ||
			static::thisMonthAmountEur() >= static::DESIRED_AMOUNT;
	}

	public static function retrieveFromZapier() {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'https://zapier.com/engine/rss/25907171/hebrewtools-donations');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		if (curl_errno($curl))
			throw curl_error($curl);
		curl_close($curl);

		$rss = simplexml_load_string($response);
		foreach($rss->channel->item as $item) {
			$info = json_decode($item->description);
			try {
				static::firstOrCreate(
					['zapier_guid' => $item->guid],
					[
						'added_at' => date('Y-m-d H:m:s', strtotime($item->pubDate)),
						'amount' => $info->amount,
						'currency' => $info->currency,
						'amount_eur' => $info->amount_eur
					]
				);
			} catch (ErrorException $e) {
				// ignore
			}
		}
	}

}
