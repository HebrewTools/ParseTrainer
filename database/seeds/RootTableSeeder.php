<?php
/**
 * Created by PhpStorm.
 * User: camil
 * Date: 1/4/16
 * Time: 4:10 PM
 */

use Illuminate\Database\Seeder;
use HebrewParseTrainer\Root;
use HebrewParseTrainer\RootTranslation;

class RootTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Root::create(['root' => 'קטל', 'strong' => true]);

        RootTranslation::create(['root' => 'קטל', 'translation' => 'kill']);
    }

}