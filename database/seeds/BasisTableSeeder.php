<?php
/**
 * HebrewParseTrainer - practice Hebrew verbs
 * Copyright (C) 2015-2021  Camil Staps <info@camilstaps.nl>
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

use Illuminate\Database\Seeder;

use HebrewParseTrainer\RootKind;
use HebrewParseTrainer\Stem;
use HebrewParseTrainer\Tense;

class BasisTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Stem::firstOrCreate(['name' => 'Qal']);
		Stem::firstOrCreate(['name' => 'Niphal']);
		Stem::firstOrCreate(['name' => 'Piel']);
		Stem::firstOrCreate(['name' => 'Pual']);
		Stem::firstOrCreate(['name' => 'Hiphil']);
		Stem::firstOrCreate(['name' => 'Hophal']);
		Stem::firstOrCreate(['name' => 'Hitpael']);

		Tense::firstOrCreate(['name' => 'perfect',                  'abbreviation' => 'pf']);
		Tense::firstOrCreate(['name' => 'imperfect',                'abbreviation' => 'ipf']);
		Tense::firstOrCreate(['name' => 'cohortative',              'abbreviation' => 'coh']);
		Tense::firstOrCreate(['name' => 'imperative',               'abbreviation' => 'imp']);
		Tense::firstOrCreate(['name' => 'jussive',                  'abbreviation' => 'ius']);
		Tense::firstOrCreate(['name' => 'infinitive construct',     'abbreviation' => 'infcs']);
		Tense::firstOrCreate(['name' => 'infinitive absolute',      'abbreviation' => 'infabs']);
		Tense::firstOrCreate(['name' => 'participle',               'abbreviation' => 'ptc']);
		Tense::firstOrCreate(['name' => 'passive participle (qal)', 'abbreviation' => 'ptcp']);

		RootKind::firstOrCreate(['strong' => true,  'name' => 'Strong']);
		RootKind::firstOrCreate(['strong' => false, 'name' => 'I-Guttural']);
		RootKind::firstOrCreate(['strong' => false, 'name' => 'I-Aleph']);
		RootKind::firstOrCreate(['strong' => false, 'name' => 'I-Nun']);
		RootKind::firstOrCreate(['strong' => false, 'name' => 'I-Waw']);
		RootKind::firstOrCreate(['strong' => false, 'name' => 'I-Yod']);
		RootKind::firstOrCreate(['strong' => false, 'name' => 'II-Guttural']);
		RootKind::firstOrCreate(['strong' => false, 'name' => 'III-He']);
		RootKind::firstOrCreate(['strong' => false, 'name' => 'Biconsonantal']);
		RootKind::firstOrCreate(['strong' => false, 'name' => 'Geminate']);
		RootKind::firstOrCreate(['strong' => false, 'name' => 'Double weak']);
	}

}
