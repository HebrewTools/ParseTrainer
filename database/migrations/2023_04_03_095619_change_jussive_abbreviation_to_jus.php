<?php

use Illuminate\Database\Migrations\Migration;

use HebrewParseTrainer\Tense;

class ChangeJussiveAbbreviationToJus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
			Tense::where('name', 'jussive')->update(['abbreviation' => 'jus']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
			Tense::where('name', 'jussive')->update(['abbreviation' => 'ius']);
    }
}
