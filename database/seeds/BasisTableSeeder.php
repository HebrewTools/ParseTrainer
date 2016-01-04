<?php
/**
 * Created by PhpStorm.
 * User: camil
 * Date: 1/4/16
 * Time: 4:10 PM
 */

use Illuminate\Database\Seeder;
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

        Tense::create(['name' => 'perfect',                 'abbreviation' => 'pf']);
        Tense::create(['name' => 'imperfect',               'abbreviation' => 'ipf']);
        Tense::create(['name' => 'cohortative',             'abbreviation' => 'coh']);
        Tense::create(['name' => 'imperative',              'abbreviation' => 'imp']);
        Tense::create(['name' => 'jussive',                 'abbreviation' => 'ius']);
        Tense::create(['name' => 'infinitive construct',    'abbreviation' => 'infcs']);
        Tense::create(['name' => 'infinitive absolute',     'abbreviation' => 'infabs']);
        Tense::create(['name' => 'participle active',       'abbreviation' => 'pta']);
        Tense::create(['name' => 'participle passive',      'abbreviation' => 'ptp']);
    }

}