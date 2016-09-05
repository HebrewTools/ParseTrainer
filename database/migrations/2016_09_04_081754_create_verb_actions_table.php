<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVerbActionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('verb_actions', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('verb_id')->unsigned();
			$table->tinyInteger('kind');
			$table->tinyInteger('vote_weight')->nullable();
			$table->string('comment_text')->nullable();
			$table->timestamp('date')->default(DB::raw('CURRENT_TIMESTAMP'));

			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('verb_id')->references('id')->on('verbs');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('verb_actions');
	}
}
