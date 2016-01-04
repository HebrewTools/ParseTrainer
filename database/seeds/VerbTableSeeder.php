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
use HebrewParseTrainer\Verb;

class VerbTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Verb::create(['verb' => 'קָטַל', 'root' => 'קטל', 'stem' => 'Qal',
            'tense' => 'perfect', 'person' => 3, 'gender' => 'm', 'number' => 's']);
        Verb::create(['verb' => 'קָֽטְלָה', 'root' => 'קטל', 'stem' => 'Qal',
            'tense' => 'perfect', 'person' => 3, 'gender' => 'f', 'number' => 's']);
        Verb::create(['verb' => 'קָטַ֫לְתָּ', 'root' => 'קטל', 'stem' => 'Qal',
            'tense' => 'perfect', 'person' => 2, 'gender' => 'm', 'number' => 's']);
        Verb::create(['verb' => 'קָטַלְתְּ', 'root' => 'קטל', 'stem' => 'Qal',
            'tense' => 'perfect', 'person' => 2, 'gender' => 'f', 'number' => 's']);
        Verb::create(['verb' => 'קָטַ֫לְתִּי', 'root' => 'קטל', 'stem' => 'Qal',
            'tense' => 'perfect', 'person' => 1, 'gender' => 'c', 'number' => 's']);

        Verb::create(['verb' => 'קָֽטְלוּ', 'root' => 'קטל', 'stem' => 'Qal',
            'tense' => 'perfect', 'person' => 3, 'gender' => 'c', 'number' => 'p']);
        Verb::create(['verb' => 'קְטַלְתֶּם', 'root' => 'קטל', 'stem' => 'Qal',
            'tense' => 'perfect', 'person' => 2, 'gender' => 'm', 'number' => 'p']);
        Verb::create(['verb' => 'קְטַלְתֶּן', 'root' => 'קטל', 'stem' => 'Qal',
            'tense' => 'perfect', 'person' => 2, 'gender' => 'f', 'number' => 'p']);
        Verb::create(['verb' => 'קָטַ֫לְנוּ', 'root' => 'קטל', 'stem' => 'Qal',
            'tense' => 'perfect', 'person' => 1, 'gender' => 'c', 'number' => 'p']);
    }

}