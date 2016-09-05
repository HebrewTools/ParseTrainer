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
		Stem::create(['name' => 'Qal']);
		Stem::create(['name' => 'Niphal']);
		Stem::create(['name' => 'Piel']);
		Stem::create(['name' => 'Pual']);
		Stem::create(['name' => 'Hiphil']);
		Stem::create(['name' => 'Hophal']);
		Stem::create(['name' => 'Hitpael']);

		Tense::create(['name' => 'perfect',              'abbreviation' => 'pf']);
		Tense::create(['name' => 'imperfect',            'abbreviation' => 'ipf']);
		Tense::create(['name' => 'cohortative',          'abbreviation' => 'coh']);
		Tense::create(['name' => 'imperative',           'abbreviation' => 'imp']);
		Tense::create(['name' => 'jussive',              'abbreviation' => 'ius']);
		Tense::create(['name' => 'infinitive construct', 'abbreviation' => 'infcs']);
		Tense::create(['name' => 'infinitive absolute',  'abbreviation' => 'infabs']);
		Tense::create(['name' => 'participle active',    'abbreviation' => 'pta']);
		Tense::create(['name' => 'participle passive',   'abbreviation' => 'ptp']);

		RootKind::create(['strong' => true,  'name' => 'Strong']);
		RootKind::create(['strong' => false, 'name' => 'I-Guttural']);
		RootKind::create(['strong' => false, 'name' => 'I-Aleph']);
		RootKind::create(['strong' => false, 'name' => 'I-Nun']);
		RootKind::create(['strong' => false, 'name' => 'I-Waw']);
		RootKind::create(['strong' => false, 'name' => 'I-Yod']);
		RootKind::create(['strong' => false, 'name' => 'II-Guttural']);
		RootKind::create(['strong' => false, 'name' => 'III-He']);
		RootKind::create(['strong' => false, 'name' => 'Biconsonantal']);
		RootKind::create(['strong' => false, 'name' => 'Geminate']);
		RootKind::create(['strong' => false, 'name' => 'Double weak']);
	}

}
