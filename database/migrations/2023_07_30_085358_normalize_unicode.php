<?php

use Illuminate\Database\Migrations\Migration;

use HebrewParseTrainer\Verb;

class NormalizeUnicode extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Verb::each(function ($verb, $key) {
			if (!Normalizer::isNormalized($verb->verb)) {
				$verb->verb = Normalizer::normalize($verb->verb);
				$verb->save();
			}
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * Previously no guarantees were given on the form, so we do not have to do
	 * anything.
	 *
	 * @return void
	 */
	public function down()
	{
	}
}
