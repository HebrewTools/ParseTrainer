<?php
/**
 * Created by PhpStorm.
 * User: camil
 * Date: 1/4/16
 * Time: 4:26 PM
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