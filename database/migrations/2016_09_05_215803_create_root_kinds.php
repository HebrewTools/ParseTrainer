<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRootKinds extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('root_kinds', function (Blueprint $table) {
			$table->increments('id');
			$table->boolean('strong');
			$table->string('name')->unique();
		});
		
		Schema::table('roots', function (Blueprint $table) {
			$table->dropColumn('strong');

			$table->integer('root_kind_id')->unsigned()->nullable();
			$table->foreign('root_kind_id')->references('id')->on('root_kinds');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('roots', function (Blueprint $table) {
			$table->dropForeign(['root_kind_id']);
			$table->dropColumn('root_kind_id');

			$table->boolean('strong')->default(1);
		});

		Schema::drop('root_kinds');
	}
}
