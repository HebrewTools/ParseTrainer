<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use HebrewParseTrainer\Tense;
use HebrewParseTrainer\Verb;

class RenameParticiple extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Tense::create(['name' => 'participle',               'abbreviation' => 'ptc']);
		Tense::create(['name' => 'passive participle (qal)', 'abbreviation' => 'ptcp']);

		Verb::where('tense', 'participle active')->update(['tense' => 'participle']);
		Verb::where('tense', 'participle passive')->update(['tense' => 'passive participle (qal)']);

		Tense::where('name', 'participle active')->delete();
		Tense::where('name', 'participle passive')->delete();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Tense::create(['name' => 'participle active',  'abbreviation' => 'pta']);
		Tense::create(['name' => 'participle passive', 'abbreviation' => 'ptp']);

		Verb::where('tense', 'participle')->update(['tense' => 'participle active']);
		Verb::where('tense', 'passive participle (qal)')->update(['tense' => 'participle passive']);

		Tense::where('name', 'participle')->delete();
		Tense::where('name', 'passive participle (qal)')->delete();
	}
}
