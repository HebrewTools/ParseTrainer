<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointChangesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('point_changes', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('verb_id')->unsigned()->nullable();
			$table->tinyInteger('kind')->unsigned();
			$table->integer('change');
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
		Schema::drop('point_changes');
	}
}
