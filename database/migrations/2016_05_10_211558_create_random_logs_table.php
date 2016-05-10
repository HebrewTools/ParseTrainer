<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRandomLogsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('random_logs', function (Blueprint $table) {
			$table->increments('id');
			$table->string('request', 1023)->collate('utf8_general_ci');
			$table->string('response', 24)->collate('utf8_general_ci');
			$table->timestamp('created_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('random_logs');
	}
}
